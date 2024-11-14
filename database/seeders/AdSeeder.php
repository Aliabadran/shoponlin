<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Category;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run()
    {
        // Example categories (if they don't exist already, create them)
        $categories = ['Electronics', 'Fashion', 'Home Appliances'];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        // Fetch the categories to use in ads
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        $fashionCategory = Category::where('name', 'Fashion')->first();
        $homeAppliancesCategory = Category::where('name', 'Home Appliances')->first();

        // Sample ads
        $ads = [
            [
                'title' => '50% Off on Smartphones',
                'description' => 'Grab the latest smartphones at half the price. Limited time offer!',
                'image_path' => null, // Add image paths if available
                'is_active' => true,
                'categories' => [$electronicsCategory->id],
            ],
            [
                'title' => 'Summer Fashion Sale',
                'description' => 'Get the trendiest outfits this summer at amazing discounts.',
                'image_path' => null, // Add image paths if available
                'is_active' => true,
                'categories' => [$fashionCategory->id],
            ],
            [
                'title' => 'Home Appliances Mega Sale',
                'description' => 'Upgrade your home with the latest appliances at unbelievable prices.',
                'image_path' => null, // Add image paths if available
                'is_active' => true,
                'categories' => [$homeAppliancesCategory->id],
            ],
            [
                'title' => 'New Arrival - Designer Watches',
                'description' => 'Check out our latest collection of luxury designer watches.',
                'image_path' => null, // Add image paths if available
                'is_active' => true,
                'categories' => [$fashionCategory->id],
            ],
        ];


        // Create ads and associate them with categories
        foreach ($ads as $adData) {
            $ad = Ad::create([
                'title' => $adData['title'],
                'description' => $adData['description'],
                'image_path' => $adData['image_path'],
                'is_active' => $adData['is_active'],
            ]);

            // Attach categories to the ad
            $ad->categories()->attach($adData['categories']);
        }
    }

    //php artisan db:seed --class=AdSeeder

}

