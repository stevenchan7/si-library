<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array('student', 'librarian', 'admin');

        foreach ($roles as $role) {
            Role::create([
                'title' => $role
            ]);
        }
    }
}
