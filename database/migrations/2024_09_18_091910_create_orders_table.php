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
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relating to users table
                $table->decimal('total', 10, 2); // Total amount for the order
                $table->string('address'); // Shipping address
                $table->enum('payment_method', ['credit_card', 'cash_on_delivery']); // Payment method choice
                $table->enum('delivery_option', ['home_delivery', 'pickup']); // Delivery option choice
                $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending'); // Order status
                $table->timestamps(); // Created at and updated at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
