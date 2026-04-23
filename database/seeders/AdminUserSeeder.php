<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cafe.com'], // Checks if this email exists
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'), // Default password
                'role' => 'admin', // Make sure this matches your role column name
            ]
        );
    }
}