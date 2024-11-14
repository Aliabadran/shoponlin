<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
//use Barryvdh\DomPDF\PDF;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderVerificationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\UserInteractionService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;
use App\Notifications\OrderConfirmedNotification;
use App\Notifications\OrderVerificationNotification;

class OrderController extends Controller
{

    public function __construct()
    {
        // Apply middleware to restrict access to certain actions
        $this->middleware('auth'); // Requires user authentication for all actions

        // Define permission middleware for specific actions
        $this->middleware();
    }
    public static function middleware(): array
    {
        return [

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:checkout order'), only: ['checkout']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view admin orders'), only: ['showAllOrders', 'getOrderDetails']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view user orders'), only: ['index','OrderDetails', 'orderSuccess']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update order status'), only: ['updateStatus']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:generate order pdf'), only: ['generateOrderPdf', 'viewOrderPdf']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:cancel order'), only: ['cancel']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:verify order'), only: ['verifyOrder']),
        ];
    }
        public function checkout(Request $request)
        {
            $user = Auth::user();
            $cartItems = CartItem::where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                Alert::error('Error', 'Your cart is empty!');
                return redirect()->back();
            }

            $request->validate([
                'address' => 'required|string|max:255',
                'payment_method' => 'required|in:credit_card,cash_on_delivery',
                'delivery_option' => 'required|in:home_delivery,pickup',
                'coupon_code' => 'nullable|string|exists:coupons,code',
            ]);

            $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $coupon = null;

            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)
                    ->where('is_active', true)
                    ->where(function ($query) {
                        $query->where('expires_at', '>=', now())->orWhereNull('expires_at');
                    })->first();

                if ($coupon) {
                    if ($coupon->discount_type === 'fixed') {
                        $total -= $coupon->discount_value;
                    } elseif ($coupon->discount_type === 'percent') {
                        $total -= ($total * ($coupon->discount_value / 100));
                    }
                    $total = max(0, $total);
                }
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'delivery_option' => $request->delivery_option,
                'coupon_id' => $coupon ? $coupon->id : null,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $product = Product::find($item->product_id);
                $product->quantity -= $item->quantity;
                $product->save();
            }

            // Clear the cart and coupon after successful checkout
            CartItem::where('user_id', $user->id)->delete();
            session()->forget('coupon'); // Clear coupon session entirely



            $user->notify(new OrderConfirmedNotification($order));

            Alert::success('Success', 'Your order has been placed successfully!');
            return redirect()->route('order.success', ['order_id' => $order->id]);
        }





public function orderSuccess($order_id)
{

    // Retrieve the order with coupon and order items
    $order = Order::with(['orderItems.product', 'coupon'])->findOrFail($order_id);
    return view('cart.order.order-success', compact('order'));

}

public function showAllOrders()
{
    // Retrieve all orders, including related users and order items
    $orders = Order::with(['user', 'orderItems.product'])->get();

    // Pass the orders data to the Blade view
    return view('admin.orders-list', compact('orders'));
}


public function getOrderDetails($order_id)
{
    // Retrieve the order by ID, including related user, order items, and products
    $order = Order::with(['user', 'orderItems.product'])->findOrFail($order_id);

    // Pass the order data to the Blade view
    smilify('info', 'You are show Details To Order');
    return view('admin.order-details', compact('order'));
}


public function updateStatus(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
    ]);

    $order = Order::findOrFail($id);
    $order->status = $validated['status'];
    $order->save();

    // Display a SweetAlert success message
    Alert::success('Success', 'Order status updated successfully!');
    smilify('success', 'Order status updated successfully!');
    return redirect()->route('orders.all');
}

public function generateOrderPdf($id)
{
    $order = Order::findOrFail($id);
         // Fetch the order with its related items
      //   $order = Order::with('items')->findOrFail($orderId);

      $data = [
        'date'=>date('m/d/y'),
        'order' => $order
    ];
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.order', $data,[
        'order' => $order,
    ]);

    return $pdf->download('order_' . $order->id . '.pdf');
}

// Function to render the PDF in the browser
public function viewOrderPdf($id)
{
    $order = Order::findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.order', [
        'order' => $order,
    ]);

    return $pdf->stream('order_' . $order->id . '.pdf'); // Stream to browser
}

public function store(Request $request)
{
    $user = Auth::user();

    // Retrieve the cart items for the user
    $cartItems = CartItem::where('user_id', $user->id)->get();
    // Create the order

    $order = Order::create([
        'user_id' => $user->id,
        'total' =>  $request->total,
        'status' => 'pending', // Set initial status to pending
        'address' => $request->address,
        'payment_method' => $request->payment_method,
        'delivery_option' => $request->delivery_option,
        'valid'=>  0, // Set the valid field to 0 (not verified)
    ]);

    // Move cart items to order items
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ]);
           // Reduce product stock
           $product = Product::find($item->product_id);
           $product->quantity -= $item->quantity;
           $product->save();
                }
    // Check if the order was created successfully
    if ($order) {
        // Send the verification email
        try {
            Mail::to(Auth::user()->email)->send(new OrderVerificationEmail(Auth::user(), $order));

            // If the email is sent successfully, mark the order as valid
            $order->update(['valid' => 1]);
            notify()->success('Order placed and verified successfully!');
            return response()->json(['message' => 'Order placed and verified successfully!']);
        } catch (\Exception $e) {
            // If email sending fails, return an error message
            notify()->warning('Order placed, but email could not be sent.');
            return response()->json(['message' => 'Order placed, but email could not be sent.'], 500);
        }
    }
    notify()->error('Order creation failed.');
    return response()->json(['message' => 'Order creation failed.'], 500);
}





public function verifyOrder($orderId, $hash)
{
    $order = Order::findOrFail($orderId);

    if (sha1($order->id) === $hash) {
        $order->update(['verified' => 1]);
        $message = 'Order verified successfully!';
         // Send the verification email
    Mail::to(Auth::user()->email)->send(new OrderVerificationEmail(Auth::user(), $order));

    // Notify the user that the verification email has been sent
    auth()->user()->notify(new OrderVerificationNotification($order));
    } else {
        $message = 'Invalid verification link.';
    }
    smilify('success', 'Invalid verification link.');
    return view('emails.succussful-verification', compact('message'));
}


public function showOrderVerification(User $user, Order $order)
{
    $url= route('order.verify', ['order' => $order->id, 'hash' => sha1($order->id)]);

    return view('emails.order-verification', compact('user', 'order','url'));
}


public function show($id)
{
    // Retrieve the order by its ID
    $order = Order::findOrFail($id);

    // Return a view with the order details
    return view('order', compact('order'));
}


public function index()
{
    $orders = Order::where('user_id', Auth::id())->with('items')->get();
    return view('home.order-index', compact('orders'));
}



public function cancel($id)
{
    $order = Order::where('id', $id)->where('user_id', Auth::id())->first();

    if ($order && $order->status == Order::STATUS_PENDING) {
        $order->update(['status' => Order::STATUS_CANCELED]);

        // Show success alert
        Alert::success('Success', 'Your order has been cancelled.');
        emotify('warning', 'Your order has been cancelled.');
    } else {
        // Show error alert
        Alert::error('Error', 'You cannot cancel this order.');
        emotify('Error', 'You cannot cancel this order.');
    }

    return redirect()->back();
}

public function OrderDetails($order_id)
{
    // Retrieve the order by ID, including related user, order items, and products
    $order = Order::with(['user', 'orderItems.product'])->findOrFail($order_id);

    // Pass the order data to the Blade view
    return view('home.order-details', compact('order'));
}

}
