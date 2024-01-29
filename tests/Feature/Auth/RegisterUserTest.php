<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_register_page()
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('register');
    }

    public function test_user_cannot_see_register_page_if_authenticated()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/login')
            ->assertStatus(302)
            ->assertRedirectToRoute('home');

        $this->assertAuthenticated();
    }

    public function test_user_can_register()
    {
        $this->post('/register', [
            'name' => 'Robert Hook',
            'username' => 'robert_hook',
            'email' => 'robert@test.io',
            'password' => 'password',
        ])
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => 'Robert Hook',
            'username' => 'robert_hook',
            'email' => 'robert@test.io',
        ]);

        $user = User::first();

        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertAuthenticated();
    }

    #[DataProvider('provideInvalidInputData')]
    public function test_user_cannot_register_with_invalid_input($name, $username, $email, $password)
    {
        $this->post('/register', [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ])
            ->assertSessionHasErrors(['name', 'username', 'email', 'password']);
    }

    public static function provideInvalidInputData()
    {
        $data = [];

        // first input
        $data['null_input'] = [
            'name' => null,
            'username' => null,
            'email' => null,
            'password' => null,
        ];

        // second input
        $data['invalid_input'] = [
            'name' => 'Robert',
            'username' => 'robert$',
            'email' => 'roberttest.io',
            'password' => 'pass',
        ];

        return $data;
    }
}
