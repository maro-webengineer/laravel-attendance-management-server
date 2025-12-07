<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => env('TEST_USER_NAME', 'test_user'),
            'email' => env('TEST_USER_EMAIL', 'test@example.com'),
            'password' => 'P@ssw0rd',
        ]);
    }
}
