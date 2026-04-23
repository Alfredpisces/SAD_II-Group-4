<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('feedbacks', function (Blueprint $table) {
        $table->id();
        $table->integer('rating')->nullable(); // To store star counts
        $table->text('comments');             // To store the customer's message
        $table->timestamps();                 // Records when it was sent
    });
}

    /**
     * Reverse the migrations.
     */
   
    public function down(): void
    {
        Schema::dropIfExists('feedbacks'); // Changed from 'feedback' to 'feedbacks'
    }
};
