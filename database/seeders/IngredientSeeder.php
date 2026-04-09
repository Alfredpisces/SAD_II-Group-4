<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class IngredientSeeder extends Seeder
{
public function run(): void
{
    \App\Models\Product::truncate();

    $items = [
        // --- These stay HIDDEN from Cashier ---
        ['name' => 'Coffee Beans', 'category' => 'Raw Material', 'stock' => 5000, 'unit' => 'grams', 'min_stock' => 500, 'price' => 0],
        ['name' => 'Fresh Milk', 'category' => 'Raw Material', 'stock' => 10000, 'unit' => 'ml', 'min_stock' => 1000, 'price' => 0],
        ['name' => 'Condensed Milk', 'category' => 'Raw Material', 'stock' => 5000, 'unit' => 'ml', 'min_stock' => 500, 'price' => 0],
        ['name' => 'Matcha Powder', 'category' => 'Raw Material', 'stock' => 1000, 'unit' => 'grams', 'min_stock' => 100, 'price' => 0],
        ['name' => 'Paper Cup', 'category' => 'Raw Material', 'stock' => 500, 'unit' => 'pcs', 'min_stock' => 50, 'price' => 0],
        ['name' => 'Water', 'category' => 'Raw Material', 'stock' => 20000, 'unit' => 'ml', 'min_stock' => 2000, 'price' => 0],

        // --- These will be VISIBLE to Cashier ---
        ['name' => 'Spanish Latte', 'category' => 'Coffee', 'stock' => 0, 'unit' => 'cup', 'min_stock' => 0, 'price' => 120.00],
        ['name' => 'Matcha Latte', 'category' => 'Tea', 'stock' => 0, 'unit' => 'cup', 'min_stock' => 0, 'price' => 135.00],
        ['name' => 'Americano', 'category' => 'Coffee', 'stock' => 0, 'unit' => 'cup', 'min_stock' => 0, 'price' => 110.00],
    ];

    foreach ($items as $item) {
        \App\Models\Product::create($item);
    }
}
}