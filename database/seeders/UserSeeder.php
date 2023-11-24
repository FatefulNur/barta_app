<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Alex Hales',
                'username' => 'alex921',
                'email' => 'alex@test.com',
                'password' => Hash::make('alex1234'),
            ],
            [
                'name' => 'Peter Robinson',
                'username' => 'peter137',
                'email' => 'peter@test.com',
                'password' => Hash::make('peter1234'),
            ],
            [
                'name' => 'Harry Porter',
                'username' => 'harry977',
                'email' => 'harry@test.com',
                'password' => Hash::make('harry1234'),
            ],
        ]);
    }
}
