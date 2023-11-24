<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'body' => 'Hello. This is initial post. Thanks for watching.',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'body' => "Whats up developer. What't new on PHP 8.3.",
                'user_id' => 3,
                'created_at' => now(),
            ],
            [
                'body' => 'If you worry about your life then go to pray and worship of almighty.',
                'user_id' => 3,
                'created_at' => now(),
            ],
            [
                'body' => "Shit. What't wrong with me. I don't know the pain of frustration.",
                'user_id' => 2,
                'created_at' => now(),
            ],
        ]);
    }
}
