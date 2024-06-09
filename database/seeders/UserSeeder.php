<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Ryan Hangralim',
            'email' => 'ryan@student.com',
            'password' => 'ryan123',
            'address' => 'alamat ryan',
            'photo_url' => 'url',
            'phone_number' => '1234567890',
            'sex' => 1,
            'role_id' => 1,
            'username' => 'ryanh'
        ]);

        User::create([
            'fullname' => 'Steven Chan',
            'email' => 'steven@student.com',
            'password' => 'steven',
            'address' => 'alamat steven',
            'photo_url' => 'url',
            'phone_number' => '1234567890',
            'sex' => 1,
            'role_id' => 2,
            'username' => 'stevenc'
        ]);

        User::create([
            'fullname' => 'Gemuh Raharja',
            'email' => 'gemuh@student.com',
            'password' => 'gemuh',
            'address' => 'alamat gemuh',
            'photo_url' => 'url',
            'phone_number' => '1234567890',
            'sex' => 1,
            'role_id' => 3,
            'username' => 'gemuhr'
        ]);
    }
}
