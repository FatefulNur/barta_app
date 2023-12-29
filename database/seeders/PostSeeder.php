<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(15)->forUser(['email' => 'author@test.com'])->create();
        Post::factory()->count(15)->forUser(['email' => 'editor@test.com'])->create();
    }
}
