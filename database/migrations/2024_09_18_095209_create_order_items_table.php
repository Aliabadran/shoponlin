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
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relating to orders table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relating to products table
            $table->integer('quantity'); // Quantity of the product ordered
            $table->decimal('price', 10, 2); // Price at the time of order
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
