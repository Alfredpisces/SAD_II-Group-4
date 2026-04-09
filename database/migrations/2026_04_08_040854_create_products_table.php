<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the coffee/food
            $table->decimal('price', 8, 2); // Price (e.g., 125.00)
            $table->integer('stock')->default(0); // How many items are left
            $table->string('category')->default('Beverage'); // Coffee, Pastry, etc.
            $table->string('image')->nullable(); // Optional: path to product image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};