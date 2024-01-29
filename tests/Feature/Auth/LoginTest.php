<?php

namespace Tests\Feature\Auth;

use Tests\CustomTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class LoginTest extends CustomTestCase
{
    public function test_user_can_see_login_page()
    {
        $this->get('/login')
            ->assertOk()
            ->assertViewIs('login');
    }

    public function test_user_cannot_see_login_page_if_authenticated()
    {
        $this
            ->actingAs($this->user)
            ->get('/login')
            ->assertStatus(302)
            ->assertRedirectToRoute('home');

        $this->assertAuthenticated();
    }

    public function test_user_can_login()
    {
        $this->post('/login', [
            'email' => 'robert@test.io',
            'password' => 'password',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('home');

        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $this->post('/login', [
            'email' => 'robert@test.io',
            'password' => 'password',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('home')
            ->assertSessionDoesntHaveErrors();

        $this->assertAuthenticated();
    }

    #[DataProvider('provideInvalidInputData')]
    public function test_user_cannot_login_with_invalid_input($email, $password)
    {
        $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ])
            ->assertSessionHasErrors();
    }

    public static function provideInvalidInputData()
    {
        $data = [];

        // first input
        $data['null_input'] = [
            'email' => null,
            'password' => null,
        ];

        // second input
        $data['invalid_input'] = [
            'email' => 'roberttest.io',
            'password' => 'pass',
        ];

        // // third input
        $data['invalid_credentials'] = [
            'email' => 'bruce@test.io',
            'password' => 'password123',
        ];

        return $data;
    }

    public function test_user_can_logout()
    {
        $this->actingAs($this->user)
            ->post('/logout')
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}
