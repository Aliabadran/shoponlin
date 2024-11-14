<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image_path', 'description','is_active'];


    public static function getTargetedAds($user)
    {
        // Cache ads for the user for 30 minutes
    return Cache::remember("user_{$user->id}_targeted_ads", now()->addMinutes(30), function () use ($user) {
        // Get user preferences
        $userPreferences = $user->preferences()->pluck('preference')->toArray();

        if (empty($userPreferences)) {
            // If user preferences are empty, return default ads
            return self::where('is_active', true)->limit(10)->get(); // You can adjust the limit as needed
        }

        // Fetch ads based on user's preferences using relationship
        return self::whereHas('categories', function ($query) use ($userPreferences) {
            $query->whereIn('name', $userPreferences);
        })->where('is_active', true)->get();
    });
    }


    // Define the many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ad_category');
    }



    // Define many-to-many relationship with Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ad_product');
    }
}
