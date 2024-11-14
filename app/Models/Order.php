<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELED = 'cancelled';

    protected $fillable = ['user_id', 'total', 'address', 'payment_method', 'delivery_option', 'status','verified','coupon_id'];

    // An order belongs to a user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // An order has many order items
    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
{
    return $this->hasMany(OrderItem::class);
}
    // An order can have an optional coupon
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

}
