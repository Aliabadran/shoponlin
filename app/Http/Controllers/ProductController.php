<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserInteractionService;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert

class ProductController extends Controller
{

    protected $interactionService;

    // Inject UserInteractionService using dependency injection
    public function __construct(UserInteractionService $interactionService)
    {
        $this->interactionService = $interactionService;

             // Apply middleware to restrict access to certain actions
             $this->middleware('auth'); // Requires user authentication for all actions

             // Define permission middleware for specific actions
             $this->middleware();
   }

   public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view products'), only:['index','show', 'search']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create products'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update products'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete products'), only:['destroy']),
        ];
    }


    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('price', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->paginate(5);
            emotify('info', 'You are smile, your  show products ');
        return view('products.index', compact('products', 'query'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'discount' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : null;

        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'photo' => $photoPath,
        ]);

        // Trigger SweetAlert success message
        Alert::success('Success', 'Product created successfully.');
        notify()->success('Product created successfully.');
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'discount' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : $product->photo;

        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'photo' => $photoPath,
        ]);

        // Trigger SweetAlert success message
        Alert::success('Success', 'Product updated successfully.');
        smilify('Success', 'Product updated successfully.');
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        // Trigger SweetAlert success message
        Alert::success('Deleted', 'Product deleted successfully.');
        notify()->warning('Product deleted successfully.');
        return redirect()->route('products.index');
    }

    public function showProductsCategory(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            // Trigger SweetAlert error message
            Alert::error('Error', 'Category not found.');
            return redirect()->back();
        }

        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 10000);
        $sortBy = $request->input('sort_by', 'price');
        $sortOrder = $request->input('sort_order', 'asc');
        $searchKeyword = $request->input('search', '');
        $availability = $request->input('available', 'all');

        $productsQuery = $category->products()
            ->whereBetween('price', [$minPrice, $maxPrice])
            ->when($searchKeyword, function ($query) use ($searchKeyword) {
                return $query->where('name', 'LIKE', "%{$searchKeyword}%");
            })
            ->when($availability === 'available', function ($query) {
                return $query->where('quantity', '>', 0);
            });

        $products = $productsQuery->orderBy($sortBy, $sortOrder)->paginate(3);

        return view('products.products_by_category', compact('category', 'products', 'minPrice', 'maxPrice', 'sortBy', 'sortOrder', 'searchKeyword', 'availability'));
    }

    protected function trackProductView(Product $product)
    {
        $category = $product->category ? $product->category->name : 'Uncategorized';
        $this->interactionService->trackInteraction(Auth::id(), 'view', $category);
    }
}
