<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount_value', 'discount_type', 'is_active', 'applies_to', 'product_id', 'expires_at'];

     // Ensure the expires_at field is cast to a Carbon date instance
     protected $casts = [
        'expires_at' => 'datetime',
    ];
    // Check if the coupon is valid (active and not expired)
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        return true;
    }

    // Apply the coupon discount based on its type (fixed or percentage)
  // Inside the Coupon model
public function applyDiscount($total, $discountedItems = [])
{
    // Log the values for debugging
    \Log::info('Applying discount', [
        'discount_type' => $this->discount_type,
        'discount_value' => $this->discount_value,
        'total' => $total,
    ]);

    if ($this->discount_type === 'fixed') {
        return max(0, $total - $this->discount_value); // Fixed discount on total
    } elseif ($this->discount_type === 'percent') {
        // Apply discount to each item if there are discounted items
        if (!empty($discountedItems)) {
            $discountedTotal = array_reduce($discountedItems, function ($sum, $item) {
                return $sum + ($item['price'] * (1 - ($this->discount_value / 100)));
            }, 0);
            return max(0, $discountedTotal); // Return discounted total
        } else {
            return max(0, $total - ($total * ($this->discount_value / 100))); // Percentage discount on entire total
        }
    }

    return $total;
}


// Apply discount to individual product if coupon applies to a specific product
public function applyToProduct($product)
{
    // Check if the coupon is specifically for this product
    if ($this->applies_to !== 'product' || $this->product_id !== $product->id) {
        return $product->priceAfterDiscount(); // Return the price after the product's own discount, if any
    }

    // Calculate the product's price after applying its own discount (if any)
    $discountedPrice = $product->priceAfterDiscount();

    // Apply the coupon's discount to the already discounted price
    return $this->applyDiscount($discountedPrice);
}

    // Define the relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
