<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserInteractionService;
use App\Models\Product; // Import your Product model
use App\Models\Category; // Import your Category model

class SearchController extends Controller
   {
        // Constructor to apply middleware
        public function __construct()
        {
            // Apply auth middleware to ensure only authenticated users can access these methods
            $this->middleware('auth');
        }
       public function index(Request $request)
        {
            $query = $request->input('query');
            $user = Auth::user();
            // Search products and categories
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            $categories = Category::where('name', 'like', "%{$query}%")->get();

            // Combine products and categories, sort as needed
            $results = $products->concat($categories)->sortBy('name'); // Change 'name' to the desired order field
          // Track the search interaction
          app(UserInteractionService::class)->trackInteraction(Auth::id(), UserInteractionService::INTERACTION_TYPE_SEARCH, $query);

            return view('home.search-results', compact('results', 'query'));
        }



        public function check(Request $request)
        {
            $search = $request->input('search');

            // Search users
            $users = User::where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->get();

            // Search products
            $products = Product::where('name', 'like', "%{$search}%")
                               ->orWhere('description', 'like', "%{$search}%")
                               ->get();

            // Search orders
            $orders = Order::where('total', 'like', "%{ $search }%")
            ->orWhere('payment_method', 'like', "%{$search}%")
            ->orWhere('delivery_option', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->get();

            // Search categories
            $categories = Category::where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->get();


            // Check if any results exist
          if ($users->isEmpty() && $products->isEmpty() && $orders->isEmpty() && $categories->isEmpty()) {
             return view('admin.CheckResults')->with('message', 'No results found.');
          }

            return view('admin.CheckResults', compact('users', 'products', 'orders', 'categories'));

        }


        public function ProductSearchHome(Request $request)
        {
            $searchQuery = $request->input('query'); // Get the search query from the request
            $user = Auth::user();
            // Search for products using the query, and paginate the results
            $products = Product::where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->orWhere('price', 'like', '%' . $searchQuery . '%')
                ->with('comments') // Include related comments
                ->paginate(10); // Paginate the results with 10 products per page
               // Track the search interaction
             app(UserInteractionService::class)->trackInteraction(Auth::id(), UserInteractionService::INTERACTION_TYPE_SEARCH, $searchQuery);

            return view('home.products_search', compact('products', 'searchQuery'));
        }

    }
