<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Caramel Macchiato', 'price' => 120.00, 'stock' => 50, 'category' => 'Coffee', 'created_at' => now()],
            ['name' => 'Matcha Latte', 'price' => 130.00, 'stock' => 40, 'category' => 'Coffee', 'created_at' => now()],
            ['name' => 'Spanish Latte', 'price' => 125.00, 'stock' => 35, 'category' => 'Coffee', 'created_at' => now()],
            ['name' => 'Dalgona Coffee', 'price' => 115.00, 'stock' => 20, 'category' => 'Coffee', 'created_at' => now()],
            ['name' => 'Croissant', 'price' => 85.00, 'stock' => 15, 'category' => 'Pastry', 'created_at' => now()],
            ['name' => 'Chocolate Muffin', 'price' => 75.00, 'stock' => 10, 'category' => 'Pastry', 'created_at' => now()],
            ['name' => 'Iced Americano', 'price' => 95.00, 'stock' => 60, 'category' => 'Coffee', 'created_at' => now()],
            ['name' => 'Dark Mocha', 'price' => 140.00, 'stock' => 25, 'category' => 'Coffee', 'created_at' => now()],
        ]);
    }
}