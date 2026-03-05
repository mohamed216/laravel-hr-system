<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hr-system.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create HR User
        User::create([
            'name' => 'HR Manager',
            'email' => 'hr@hr-system.com',
            'password' => Hash::make('hr123456'),
            'role' => 'hr',
        ]);

        // Create Employee User
        User::create([
            'name' => 'Employee',
            'email' => 'employee@hr-system.com',
            'password' => Hash::make('emp123456'),
            'role' => 'employee',
        ]);
    }
}
