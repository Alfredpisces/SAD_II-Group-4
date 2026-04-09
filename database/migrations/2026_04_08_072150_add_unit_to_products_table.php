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
        Schema::table('products', function (Blueprint $table) {
            // Adds the measurement unit (e.g., 'grams', 'ml', 'pcs')
            $table->string('unit')->default('grams')->after('stock');
            
            // Adds a threshold for low stock alerts
            $table->integer('min_stock')->default(500)->after('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'min_stock']);
        });
    }
};