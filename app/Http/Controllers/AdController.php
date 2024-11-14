<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\UserInteractionService;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert

class AdController extends Controller
{



    protected $interactionService;

    public function __construct(UserInteractionService $interactionService)
    {
        $this->interactionService = $interactionService;

            // Apply authentication middleware
            $this->middleware('auth');

            // Apply permission middleware for specific actions
            $this->middleware();
           }

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view ads'), only:['index', 'showAdsToUser', 'showAdsBasedOnInteraction']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:show ads'), only:[ 'showAdsToUser', 'showAdsBasedOnInteraction']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create  ads'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update ads'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete ads'), only:['destroy']),
        ];
    }




    public function index()
    {

        $ads = Ad::with('categories')->get();
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch categories for selection
        $products = Product::all(); // Fetch all products for selection
        return view('admin.ads.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category_ids' => 'required|array', // Array of category IDs
            'category_ids.*' => 'exists:categories,id',
            'product_ids' => 'required|array', // Add this for product IDs
            'product_ids.*' => 'exists:products,id', // Validate product IDs
            'image_path' => 'required|image',
            'is_active' => 'required|boolean',
        ]);

        // Handle image upload
        $imagePath = $request->file('image_path')->store('ads', 'public');

        // Create the ad
        $ad = Ad::create([
            'title' => $request->input('title'),
            'image_path' => $imagePath,
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active'),
        ]);


        // Attach categories to the ad
        $ad->categories()->attach($request->input('category_ids'));

        $ad->products()->attach($request->input('product_ids')); // Attach products
        // Display success message with SweetAlert
        Alert::success('Success', 'Ad created successfully.');
        drakify('success') ;
        return redirect()->route('ads.index');

    }

    public function edit(Ad $ad)
    { $categories = Category::all();
        $products = Product::all(); // Fetch all products for selection
        return view('admin.ads.edit', compact('ad', 'categories', 'products'));
      }


    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
         //   'category' => 'required|string',
           'category_ids' => 'required|array', // Array of category IDs
           'category_ids.*' => 'exists:categories,id',
           'product_ids' => 'required|array', // Add this for product IDs
           'product_ids.*' => 'exists:products,id', // Validate product IDs
            'is_active' => 'required|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('ads', 'public');
            $ad->image_path = $imagePath;
        }
        $ad->update([
            'title' => $request->input('title'),
        //    'category' => $request->input('category'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', true),

        ]);
         // Sync categories with the ad
        $ad->categories()->sync($request->input('category_ids'));
            // Sync products with the ad
         $ad->products()->sync($request->input('product_ids')); // Sync products
            // Display success message with SweetAlert
            Alert::success('Success', 'Ad updated successfully.');
            notify()->success('Ad updated successfully ⚡️');
            return redirect()->route('ads.index');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        // Display success message with SweetAlert
        Alert::success('Success', 'Ad deleted successfully.');
        return redirect()->route('ads.index');

    }

    public function updatePreferences(Request $request)
{
    $user = auth()->user();
    $preferences = $request->input('preferences'); // Example input: ['electronics', 'fashion']

    // Update preferences
    $user->preferences()->delete();
    foreach ($preferences as $preference) {
        $user->preferences()->create(['preference' => $preference]);
    }

    // Add SweetAlert notification for success
    Alert::success('Success', 'Your preferences have been updated successfully.');

    // Redirect back to the preferences page or any other page
    return redirect()->back();
}



    // Display ads on the user page based on preferences
    public function showAdsToUser()
    {
        $user = Auth::user();
        $userPreferences = $user->preferences()->pluck('preference')->toArray();


           // Cache ads for 30 minutes to reduce database queries
           $ads = Cache::remember("user_{$user->id}_ads", now()->addMinutes(30), function () use ($userPreferences) {
            return Ad::whereHas('categories', function ($query) use ($userPreferences) {
                $query->whereIn('name', $userPreferences);
            })->where('is_active', true)->get();
        });
        return view('home.ads.user_ads', compact('ads'));
    }




    public function trackAdInteraction(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|exists:ads,id',
        ]);

        $userId = Auth::id();  // Get the current authenticated user
        $adId = $request->input('ad_id');  // Get the ad ID from the request

        // Fetch the ad to get its title (or another string property)
        $ad = Ad::findOrFail($adId);

        // Use the UserInteractionService to track the interaction
        $this->interactionService->trackInteraction($userId, 'click', $ad->title);  // Store the ad title instead of ID

        // Add SweetAlert notification for success
        Alert::success('Success', 'Your interaction with the ad has been tracked successfully.');
        notify()->Success('Your interaction with the ad has been tracked successfully.');
        // Redirect back or to another page
        return redirect()->back();
    }



    public function showAdsBasedOnInteraction()
    {
        $user = Auth::user();

        // Step 1: Fetch user's interactions (e.g., clicks, views)
        $interactedAdIds = UserInteraction::where('user_id', $user->id)
        ->whereIn('interaction_type', ['click', 'view'])  // Fetch both clicks a
            //->whereIn('interaction_type', ['click', 'view','purchase','search'])  // Fetch both clicks and views, adjust as needed
            ->pluck('interaction_value')  // This gives us the ad IDs they interacted with
            ->toArray();

        // Step 2: Fetch ads based on user preferences (using UserPreference)
        $preferredCategories = $user->preferences->pluck('preference')->toArray();

        // Step 3: Fetch ads that match both the user's interactions and their preferences
        $ads = Ad::whereIn('id', $interactedAdIds)
            ->whereHas('categories', function ($query) use ($preferredCategories) {
                $query->whereIn('name', $preferredCategories);
            })
            ->where('is_active', true)
            ->get();

        // Step 4: Pass the ads to the Blade view
        return view('home.ads.interaction_ads', compact('ads'));
    }






}
