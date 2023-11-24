<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            [
                'body' => 'This is testing comment.........',
                'user_id' => 3,
                'post_id' => 4,
                'created_at' => now(),
            ],
            [
                'body' => 'Hellow how are you man????',
                'user_id' => 1,
                'post_id' => 4,
                'created_at' => now(),
            ],
            [
                'body' => 'I love PHP.',
                'user_id' => 3,
                'post_id' => 2,
                'created_at' => now(),
            ],
            [
                'body' => 'Oh its not good to me',
                'user_id' => 2,
                'post_id' => 3,
                'created_at' => now(),
            ],
        ]);
    }
}
