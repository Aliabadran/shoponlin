<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id', 'discount', 'photo'];

    protected $casts = [
        'price' => 'float',
        'discount' => 'float',
        'quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function priceAfterDiscount()
    {
        $discountAmount = $this->price * ($this->discount / 100);
        return $this->price - $discountAmount;

    }
     public function carts() {
        return $this->hasMany(CartItem::class);
    }
       // A product can appear in many order items
       public function orderItems() {
        return $this->hasMany(OrderItem::class);
       }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

      // Define many-to-many relationship with Ad
      public function ads()
      {
          return $this->belongsToMany(Ad::class, 'ad_product');
      }
}
