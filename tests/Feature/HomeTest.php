<?php

namespace Tests\Feature;

use Tests\CustomTestCase;

class HomeTest extends CustomTestCase
{
    public function test_user_can_see_home_page()
    {
        $this->actingAs($this->user)
            ->get('/')
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_home_page_if_unauthenticated()
    {
        $this->get('/')
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}
