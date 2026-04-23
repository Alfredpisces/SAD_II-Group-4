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
        // 1. Create a Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@cafe.com'], 
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Create a Default Staff/Cashier User
        // This follows your leader's instruction to provide pre-made accounts
        User::updateOrCreate(
            ['email' => 'staff@cafe.com'],
            [
                'name' => 'Cashier One',
                'password' => Hash::make('staff123'),
                'role' => 'staff', // Ensure your 'users' table migration has a 'role' column
            ]
        );

        // 3. Create Default Menu Products & Ingredients
        $products = [
            // Raw Materials / Ingredients
            ['name' => 'Coffee Beans', 'category' => 'Raw Material', 'stock' => 5000, 'price' => 0],
            ['name' => 'Fresh Milk', 'category' => 'Raw Material', 'stock' => 5000, 'price' => 0],
            ['name' => 'Condensed Milk', 'category' => 'Raw Material', 'stock' => 5000, 'price' => 0],
            ['name' => 'Paper Cup', 'category' => 'Raw Material', 'stock' => 1000, 'price' => 0],

            // Finished Products for the Cashier Menu
            ['name' => 'Americano', 'category' => 'Beverage', 'stock' => 100, 'price' => 85],
            ['name' => 'Caffe Latte', 'category' => 'Beverage', 'stock' => 100, 'price' => 110],
            ['name' => 'Spanish Latte', 'category' => 'Beverage', 'stock' => 100, 'price' => 125],
            ['name' => 'Caramel Macchiato', 'category' => 'Beverage', 'stock' => 100, 'price' => 135],
            ['name' => 'Glazed Donut', 'category' => 'Pastry', 'stock' => 20, 'price' => 55],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['name' => $item['name']], 
                $item
            );
        }
    }
}