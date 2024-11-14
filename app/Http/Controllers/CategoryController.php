<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller
{
   
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view categories'), only:['index', 'show', 'search']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create categories'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:edit categories'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete categories'), only:['destroy']),

        ];
    }
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        // Validate the search query
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Fetch categories that match the search query
        $query = $request->input('query');
        $categories = Category::where('name', 'LIKE', "%{$query}%")
        ->orWhere('description', 'LIKE', "%{$query}%")->get();

        // Return search results
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : null;

        Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'photo' => $photoPath,
        ]);

        Alert::success('Success', 'Category created successfully.');
        notify()->success('Category created successfully.');
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : $category->photo;

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'photo' => $photoPath,
        ]);

        Alert::success('Success', 'Category updated successfully.');
        notify()->success('Category updated successfully.');
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        // Trigger the SweetAlert confirmation on the frontend
        // Perform deletion only if confirmed via SweetAlert
        $category->delete();
        Alert::success('Deleted!', 'Category has been deleted successfully.');
        notify()->success('Category has been deleted successfully.');
        return redirect()->route('categories.index');
    }

    public function showProducts($id)
    {
        // Fetch the category with related products
        $category = Category::with('products')->findOrFail($id);
        // Pass the category and products to a view
        return view('categories.products', compact('category'));
    }
}
