<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create(['email' => 'admin@test.com']);
        $user2 = User::factory()->create(['email' => 'user@test.com']);

        Comment::factory()->for($user2)->create();
        Comment::factory(2)->for($user)->create();

        Post::factory()->for($user2)->create();
        Post::factory()->for($user)->create();
        Post::factory()->for($user2)->create();
    }
}
