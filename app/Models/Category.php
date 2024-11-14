<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'photo'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
         // Define the many-to-many relationship with Ad
    public function ads()
    {
        return $this->belongsToMany(Ad::class, 'ad_category');
    }

}
