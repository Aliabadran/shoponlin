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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Coupon code
            $table->decimal('discount_value', 8, 2); // Discount amount
            $table->enum('discount_type', ['fixed', 'percent']); // Discount type (fixed or percentage)
            $table->boolean('is_active')->default(true); // To mark the coupon as active or inactive
            $table->enum('applies_to', ['product', 'cart', 'order'])->default('cart'); // Coupon application scope (product, cart, order)
            $table->unsignedBigInteger('product_id')->nullable(); // Optional product ID, only if coupon applies to a specific product
            $table->timestamp('expires_at')->nullable(); // Expiration date
            $table->timestamps();

            // Foreign key to product if applicable
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
