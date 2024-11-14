<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\Auth;
use App\Services\UserInteractionService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;


class CartController extends Controller
{


  
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:add to cart'), only:['addToCart']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view cart'), only:['showCart', 'checkout']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update cart'), only:['updateCart']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:remove from carts'), only:['removeFromCart']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:apply coupon'), only:['applyCoupon']),

        ];
    }

    public function addToCart(Request $request)
{
    // Check if a coupon is applied and restrict adding new products
    if (session()->has('coupon') && session('coupon')['applied']) {
        Alert::error('Error', 'You cannot add new products while a coupon is active. Complete or remove the coupon to modify your cart.');
        return redirect()->route('cart.show');
    }

    $product = Product::findOrFail($request->product_id);
    $category = $product->category ? $product->category->name : 'Uncategorized';

    // Remaining add-to-cart logic
    $user = Auth::user();
    if (!$user) {
        return redirect()->back()->with(['error' => 'User not authenticated'], 401);
    }

    $quantity = intval($request->quantity);
    $price = floatval($product->price);
    $discount = floatval($product->discount);

    if ($product->quantity <= 0 || $product->quantity < $request->quantity) {
        return redirect()->back()->with(['error' => 'Not enough stock'], 400);
    }

    $price = $discount > 0.0 ? $price - ($price * ($discount / 100)) : $price;
    $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $product->id)->first();

    if ($cartItem) {
        $cartItem->quantity += $request->quantity;
        $cartItem->price = $price * $cartItem->quantity;
        $cartItem->save();
    } else {
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => intval($request->quantity),
            'price' => $price * $request->quantity,
        ]);
    }

    $product->quantity -= $request->quantity;
    $product->save();

    if (Auth::check()) {
        UserInteraction::create([
            'user_id' => Auth::id(),
            'interaction_type' => 'add_to_cart',
            'interaction_value' => $category,
        ]);
    }

    Alert::success('Success', 'Product added to cart successfully');
    notify()->success('Product added to cart successfully!');
    return redirect()->route('cart.show');
}



    public function checkout()
    {
        $cartItems = CartItem::where('user_id',  Auth::id())->get();



        // Calculate total price
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price;
        });

        return response()->json([
            'cart_items' => $cartItems,
            'total_price' => $totalPrice
        ]);
    }


    public function showCart()
    {
        // Retrieve Cart Items with Product data
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        // Calculate total price with discount applied to each product individually
        $totalPrice = $cartItems->sum(function ($item) {
            $price = $item->product->price;
            $discount = $item->product->discount;
            $discountedPrice = $discount > 0.0 ? $price - ($price * ($discount / 100)) : $price;

            return $discountedPrice * $item->quantity;
        });

        // Apply any active coupon
        $coupon = session()->get('coupon');
        $discountedTotal = $totalPrice; // Default to the original total

        if ($coupon) {
            // Check the coupon discount type
            if ($coupon['discount_type'] === 'fixed') {
                $discountedTotal -= $coupon['discount_value'];
            } elseif ($coupon['discount_type'] === 'percent') {
                $discountedTotal -= ($totalPrice * ($coupon['discount_value'] / 100));
            }

            // Ensure the discounted total does not go below zero
            $discountedTotal = max(0, $discountedTotal);
        }

        return view('cart.show', compact('cartItems', 'totalPrice', 'discountedTotal', 'coupon'));
    }





    // Update Cart Item
    public function updateCart(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$cartItem) {
            return redirect()->back()->with(['message' => 'Cart item not found'], 404);
        }

        $product = $cartItem->product;
        $quantityDifference = $request->quantity - $cartItem->quantity;

        // Check stock availability
        if ($product->quantity <= 0 || $product->quantity < $quantityDifference) {
            return redirect()->back()->with(['error' => 'Not enough stock'], 400);
        }

        // Update product stock
        $product->quantity -= $quantityDifference;
        $product->save();

        // Update cart item quantity and price based on product discount
        $cartItem->quantity = intval($request->quantity);
        $price = $product->discount > 0
            ? $product->price - ($product->price * ($product->discount / 100))
            : $product->price;

        $cartItem->price = $price * $cartItem->quantity;
        $cartItem->save();

        // Recalculate total and discounted total if coupon is applied
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum('price');

        if (session()->has('coupon') && session('coupon')['applied']) {
            $coupon = session('coupon');
            $discountedTotal = $coupon['discount_type'] === 'fixed'
                ? max(0, $totalPrice - $coupon['discount_value'])
                : max(0, $totalPrice - ($totalPrice * ($coupon['discount_value'] / 100)));

            // Update coupon data in session
            session()->put('coupon.discounted_total', $discountedTotal);
        } else {
            $discountedTotal = $totalPrice;
        }

        Alert::success('Success', 'Cart updated successfully!');
        notify()->success('Cart updated successfully ⚡️');
        return redirect()->back()->with([
            'total' => $totalPrice,
            'discounted_total' => $discountedTotal,
        ]);
    }






    // Remove Item from Cart
    public function removeFromCart($cartItemId)
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->product;

        // Restore the product stock
        $product->quantity += $cartItem->quantity;
        $product->save();

        // Remove the cart item
        $cartItem->delete();

        // Recalculate total and discounted total if coupon is applied
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum('price');

        if (session()->has('coupon') && session('coupon')['applied']) {
            $coupon = session('coupon');
            $discountedTotal = $coupon['discount_type'] === 'fixed'
                ? max(0, $totalPrice - $coupon['discount_value'])
                : max(0, $totalPrice - ($totalPrice * ($coupon['discount_value'] / 100)));

            // Update coupon data in session
            session()->put('coupon.discounted_total', $discountedTotal);
        } else {
            $discountedTotal = $totalPrice;
        }

        Alert::success('Success', 'Product removed from cart');
        drakify('error');
        return redirect()->route('cart.show')->with([
            'total' => $totalPrice,
            'discounted_total' => $discountedTotal,
        ]);
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|exists:coupons,code',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon->isValid()) {
            return redirect()->back()->withErrors(['coupon' => 'Invalid or expired coupon.']);
        }

        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        $totalPrice = $cartItems->sum(function ($item) {
            $productPrice = $item->product->discount > 0
                ? $item->product->price - ($item->product->price * ($item->product->discount / 100))
                : $item->product->price;

            $item->price = $productPrice * $item->quantity;
            $item->save();

            return $item->price;
        });

        $discountedTotal = $coupon->applies_to === 'cart'
            ? $coupon->applyDiscount($totalPrice)
            : $totalPrice;

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount_value' => $coupon->discount_value,
            'discount_type' => $coupon->discount_type,
            'discounted_total' => $discountedTotal,
            'applied' => true,
            'lock_cart' => true, // Lock the cart to prevent new items
        ]);

        Alert::success('Coupon Applied', 'Coupon applied successfully!');

        return redirect()->route('cart.show')->with([
            'discounted_total' => $discountedTotal,
            'total' => $totalPrice,
        ]);
    }

}




