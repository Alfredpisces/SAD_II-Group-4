<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Default Admin User for Login
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Create the Required Ingredients (Raw Materials)
        $ingredients = [
            ['name' => 'Coffee Beans', 'category' => 'Raw Material', 'stock' => 5000],
            ['name' => 'Fresh Milk', 'category' => 'Raw Material', 'stock' => 5000],
            ['name' => 'Condensed Milk', 'category' => 'Raw Material', 'stock' => 5000],
            ['name' => 'Paper Cup', 'category' => 'Raw Material', 'stock' => 1000],
        ];

        foreach ($ingredients as $item) {
            Product::create($item);
        }
    }
}