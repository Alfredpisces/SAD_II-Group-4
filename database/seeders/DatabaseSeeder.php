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
        // Default accounts — run: php artisan db:seed
        // Admin   : admin@cafe.com    / admin123
        // Barista : barista@cafe.com  / barista123
        // Cashier : cashier@cafe.com  / cashier123
        $defaultUsers = [
            ['name' => 'Admin User',    'email' => 'admin@cafe.com',   'password' => Hash::make('admin123'),   'role' => 'admin'],
            ['name' => 'Default Barista', 'email' => 'barista@cafe.com', 'password' => Hash::make('barista123'), 'role' => 'barista'],
            ['name' => 'Default Cashier', 'email' => 'cashier@cafe.com', 'password' => Hash::make('cashier123'), 'role' => 'cashier'],
        ];

        foreach ($defaultUsers as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        // 2. Seed all products and ingredients via IngredientSeeder
        $this->call(IngredientSeeder::class);
    }
}