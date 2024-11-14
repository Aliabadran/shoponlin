<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class CouponController extends Controller
{

    public static function middleware(): array
    {
        return [

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view coupons'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create coupons'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update coupons'), only: ['update', 'edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete coupons'), only: ['destroy']),
        ];
    }

    public function __construct()
    {
        // Apply authentication middleware to all methods
        $this->middleware('auth');
    }


    public function index()
    {
        $coupons = Coupon::with('product')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $products = Product::all(); // Assuming you want to select products for coupons
        return view('admin.coupons.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'applies_to' => 'required|in:product,cart,order',
            'product_id' => 'nullable|exists:products,id', // Validate only if applies to a product
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $products = Product::all(); // Fetch all products for the dropdown
        return view('admin.coupons.edit', compact('coupon', 'products'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'applies_to' => 'required|in:product,cart,order',
            'product_id' => 'nullable|exists:products,id', // Validate only if applies to a product
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon deleted successfully!');
    }
}
