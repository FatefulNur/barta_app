<?php

namespace Tests\Feature;

use Tests\CustomTestCase;

class SearchTest extends CustomTestCase
{
    public function test_user_can_search_for_profile()
    {
        $this
            ->actingAs($this->user)
            ->get('/search')
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_search_if_unauthenticated()
    {
        $this
            ->get('/search')
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}
