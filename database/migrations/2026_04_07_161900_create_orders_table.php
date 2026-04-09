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
    Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('item_name');
    $table->integer('quantity')->default(1);
    $table->decimal('price', 8, 2);
    $table->decimal('total', 8, 2);
    $table->string('status')->default('pending'); // Ensure this default is 'pending'
    $table->unsignedBigInteger('user_id')->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};