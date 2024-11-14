<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\CustomNotification;
use Illuminate\Routing\Controllers\Middleware;

class NotificationController extends Controller
{
    public function __construct()
    {
        // Apply middleware to ensure only authenticated users can access these methods
        $this->middleware('auth');

        // Apply permission middleware for specific actions (if using Spatie Permission package)
        $this->middleware();
    }
    public static function middleware(): array
    {
        return [

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view user notifications'), only: ['show', 'index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:mark user notifications'), only: ['markAsRead']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:send notifications'), only: ['confirmOrder', 'notifyUserWithAll']),
        ];
    }

    public function show()
    {
       $unreadNotifications = Auth::user()->unreadNotifications;
       return view('home.header', compact('unreadNotifications'));      }

    // Show all notifications


    public function index()
    {
        // Retrieve all notifications (read and unread)
        $notifications = Auth::user()->notifications;
        $unreadNotifications = auth()->user()->unreadNotifications;

        // Display a SweetAlert notification (success type)
        Alert::success('Notification Loaded', ' notification have been loaded.');

        // Use Laravel Notify to show a success notification
        notify()->success('Notification loaded successfully!');

        // Return the notifications view with the retrieved notifications
        return view('notifications', compact('notifications', 'unreadNotifications'));
    }


    // Mark notifications as read
    public function markAsRead(Request $request)
    {
        // Mark all unread notifications as read
        Auth::user()->unreadNotifications->markAsRead();

        // SweetAlert success notification
        Alert::success('Success', 'All notifications marked as read.');

        // Laravel Notify success notification
        notify()->success('All notifications have been marked as read!');

        // Redirect back with a flash message (if you prefer this approach for additional notification)
        return redirect()->back();
    }

    public function confirmOrder()
    {
        $user = auth()->user();
        $message = "Your order has been confirmed!";

        // Retrieve the order with related user and order items
        $order = Order::with(['user', 'orderItems.product'])->first();

        // Send the notification to the user using a custom notification class
        $user->notify(new CustomNotification($message));

        // SweetAlert success notification
        Alert::success('Order Confirmed', 'Your order has been confirmed successfully!');

        // Laravel Notify success notification
        notify()->success('Your order has been confirmed!');

        // Redirect back with the notifications in place
        return redirect()->back();
    }

    public function notifyUserWithAll()
    {
        // Retrieve the current authenticated user
        $user = Auth::user();

        // Custom message for the user
        $message = "This is a comprehensive notification for all events.";

        // Send a custom notification
        $user->notify(new CustomNotification($message));

        // Show SweetAlert
        Alert::info('Notification', 'This is an example notification for all types.');

        // Use Laravel Notify to show different notifications
        notify()->info('You have been notified with an info message.');
        notify()->success('Here is a success message!');
        notify()->warning('This is a warning message!');
        notify()->error('An error has occurred!');

        // Redirect back or show a view
        return redirect()->back();

        //  <a href="{{ route('notify-all') }}" class="btn btn-primary">Notify User with All Types</a>

    }


}
