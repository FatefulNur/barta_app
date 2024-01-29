<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class CustomTestCase extends TestCase
{
    use RefreshDatabase;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'robert bruce',
            'email' => 'robert@test.io',
        ]);
    }
}
