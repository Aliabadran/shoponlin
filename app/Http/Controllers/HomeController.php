<?php

namespace App\Http\Controllers;

use Cart;
use Alert;
use App\Models\Ad;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use App\Services\UserInteractionService;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;



//use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $interactionService;

    // Inject UserInteractionService using dependency injection
    public function __construct(UserInteractionService $interactionService)
    {
        $this->interactionService = $interactionService;

        // Apply authentication middleware to all methods except the public ones
        $this->middleware('auth');//->except(['index', 'product', 'category', 'productdetails', 'showProduct']);
           // Apply permission middleware for specific actions
        // $this->middleware();

    }

    public static function middleware(): array
    {
        return [

            new Middleware(PermissionMiddleware::using('permission:view user ads'), only: ['index','showAds', 'ads1']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view user products'), only: ['product', 'productdetails', 'showProduct']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view user categories'), only: ['category', 'showProductsInCategory']),
       ];
    }


    private function getAdsForUser()
    {
        // Fetch the last 3 ads for general users (fallback)
        $ads = Ad::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // If the user is logged in, we check their preferences/interactions
        if (Auth::check()) {
            $user = Auth::user();

            // Fetch user preferences
            $userPreferences = $user->preferences()->pluck('preference')->toArray();

            // Check for ads based on user preferences
            $preferredAds = Ad::whereHas('categories', function ($query) use ($userPreferences) {
                $query->whereIn('name', $userPreferences);
            })->where('is_active', true)
              ->limit(3)  // Show the last 3 preferred ads
              ->get();

            // If user has preferred ads, return those
            if ($preferredAds->isNotEmpty()) {
                return $preferredAds;
            }
        }

        // Return the fallback (last 3 general ads) if no preferences or not logged in
        return $ads;
    }

    // Main index function to pass data to the view

    public function index()
    {
       //$products=Product::all();
       $categories = Category::paginate(3);
       $products=Product::paginate(3);
     //  $user = Auth::user(); // Assuming the user is authenticated
    //  $targetedAds = Ad::all();

  //  $ads = $this->getAdsForUser();  // Use the function to get ads dynamically
    // Get all ads for non-logged-in users
    $allAds = Ad::where('is_active', true)->limit(3)  // Show the last 3 preferred ads
    ->get();

    // Initialize preferredAds as an empty collection
    $preferredAds = collect();

    // If the user is logged in, get their preferred ads
    if (Auth::check()) {
        $user = Auth::user();
        $userPreferences = $user->preferences()->pluck('preference')->toArray();

        // Fetch ads based on user preferences
        $preferredAds = Ad::whereHas('categories', function ($query) use ($userPreferences) {
            $query->whereIn('name', $userPreferences);
        })->where('is_active', true)->get();
    }

    $orderCount = Order::where('user_id', Auth::id())->count(); // Count the user's orders
    $cartItemCount = CartItem::where('user_id', Auth::id())->count();

   // notify()->success('Loge In successfully!');

  //  drakify('success');
 // smilify('success', 'You are successfully reconnected');
// $feedbacks = Feedback::all();
 $feedbacks = Feedback::where('is_public', true)->first()->limit(4)  // Show the last 3 preferred ads
 ->get();
        return view('home.home' , compact('products','categories','allAds', 'preferredAds','orderCount','cartItemCount','feedbacks'));
    }




    public function product()
    {
      // $products=Product::all();
       $products=Product::paginate(10);
        return view('home.products' ,compact('products') );
    }


    public function category()
    {
      // $products=Product::all();
      $categories = Category::paginate(10);
        return view('home.categories' ,compact('categories') );
    }



        public function productdetails($id)
        {
            // Redirect to login if the user is not logged in
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
            }

            // Fetch the product with related comments, replies, and users
            $product = Product::with('comments.replies.user')->findOrFail($id);

            // Assuming the product belongs to a category
            $categoryName = $product->category ? $product->category->name : 'Uncategorized';

            // Get the authenticated user ID
            $user_id = Auth::id();

            // Track the user's interaction using the interaction service already injected in the constructor
            $this->interactionService->trackInteraction($user_id, UserInteractionService::INTERACTION_TYPE_VIEW, $categoryName);
           // app(UserInteractionService::class)->trackInteraction($user_id, UserInteractionService::INTERACTION_TYPE_VIEW, $categoryName);
            // Return the product details view
            return view('home.prodect_details', compact('product'));



    }

    public function showProduct($id)
    {
        // Fetch the product
        $product = Product::findOrFail($id);

        // Get the authenticated user and their ID
        $user = Auth::user();
        $user_id = Auth::id();

        // Assuming the product belongs to a category
        $categoryName = $product->category ? $product->category->name : 'Uncategorized';

        // Track the user's interaction
        app(UserInteractionService::class)->trackInteraction($user_id, UserInteractionService::INTERACTION_TYPE_VIEW, $categoryName);

        return view('product.show', compact('product'));
    }

    public function showProductsInCategory($id)
    {

        if (Auth::check()) {
             // Get the authenticated user and their ID
        $user = Auth::user();
        $user_id = Auth::id();

        // Fetch the category with related products
        $category = Category::with('products')->findOrFail($id);

        // Track the category view interaction
        app(UserInteractionService::class)->trackInteraction($user_id, UserInteractionService::INTERACTION_TYPE_VIEW, $category->name);

        // Pass the category and products to a view
        return view('home.categories-products', compact('category'));
        } else {
            // Redirect to login page or return an error
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

    }





    public function ads1()
{
  //  $user = Auth::user(); // Assuming the user is authenticated
  //  $targetedAds = Ad::getTargetedAds($user);
  $user = Auth::user();

        // Get user's top preferences
        $topPreferences = $user->preferences()
                               ->orderBy('score', 'desc')
                               ->limit(3) // limit to top 3 preferences
                               ->pluck('preference')
                               ->toArray();

        // Fetch ads matching the user's preferences
        $targetedAds = Ad::whereIn('category', $topPreferences)
                         ->where('is_active', true)
                         ->get();
  return view('home.ads.show', compact('targetedAds'));

    }



    public function showAds()
{
    $user = Auth::user();

    // Check if user has preferences
    if ($user->preferences()->count() == 0) {
        // Redirect to preferences selection page if no preferences are set
        return redirect()->route('preferences.show');
    }

    // Fetch ads based on user preferences
    $ads = Ad::getTargetedAds($user);

    return view('home.ads.user_ads', compact('ads'));
}


public function showFeedbackDetails()
{
    // Fetch feedback along with the user and replies
    $feedbacks = Feedback::all();

    return view('home.layout.CustomerTestimonial', compact('feedbacks'));
}




}
