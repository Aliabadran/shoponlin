<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Task;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $rolesCount = Role::count();
        $ordersCount = Order::count();
        $usersCount = User::count();
        $orders = Order::paginate(10);
        // Example for total price and cost calculation
        $totalRevenue = Order::sum('total'); // assuming `total_price` exists in orders
        $totalCost = Product::sum('price'); // assuming `cost` exists in products
        $totalPurchase = Order::where('status', 'delivered')->sum('total');

        drakify('success') ;
        return view('admin.dashboard', compact(
            'productsCount', 'categoriesCount','orders', 'rolesCount', 'ordersCount', 'usersCount', 'totalRevenue', 'totalCost','tasks','totalPurchase'
        ));
    }

    public function show()
    {
        $tasks = Task::all();
        // Fetch counts
        $productsCount = Product::count();
        $usersCount = User::count();
        $ordersCount = Order::count();
        $categoriesCount = Category::count();
        $rolesCount = Role::count();

        // Calculate total revenue and total cost
        $totalRevenue = Order::sum('total'); // Assuming 'total_price' column in orders table
        $totalCost = Product::sum('price'); // Assuming 'cost' column in products table
        $totalPurchase = Order::where('status', 'delivered')->sum('total');
        // Order status counts
        $orderStatuses = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Payment method counts
        $paymentMethods = Order::select('payment_method', \DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method');

            $deliveryOptions= Order::select('delivery_option', \DB::raw('count(*) as count'))
            ->groupBy('delivery_option')
            ->pluck('count', 'delivery_option');

        // Prepare data for charts
        $orderStatusData = $orderStatuses->values()->all();
        $orderStatusLabels = $orderStatuses->keys()->all();

        $paymentMethodData = $paymentMethods->values()->all();
        $paymentMethodLabels = $paymentMethods->keys()->all();


        $deliveryOptionData = $deliveryOptions->values()->all();
        $deliveryOptionLabels = $deliveryOptions->keys()->all();

        return view('admin.chars', compact(
            'productsCount', 'usersCount', 'ordersCount', 'categoriesCount', 'rolesCount',
            'totalPurchase',  'totalRevenue', 'totalCost', 'orderStatusData', 'orderStatusLabels',
            'paymentMethodData', 'paymentMethodLabels',
            'deliveryOptionData', 'deliveryOptionLabels','tasks'
        ));
    }
}







