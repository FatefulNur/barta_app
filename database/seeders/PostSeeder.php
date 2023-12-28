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
        Post::factory()->count(23)
            ->sequence(fn(Sequence $sequence) => ['created_at' => now()->subMonths(2)->addDays($sequence->index)])
            ->forUser([
                'email' => 'author@test.com'
            ])->create();
    }
}
