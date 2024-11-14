<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller
{



    public function __construct()
    {
        // Apply authentication middleware to ensure only logged-in users can access these methods
        $this->middleware('auth');

        // Apply permission middleware for specific actions
        $this->middleware();
     }

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view admin notifications'), only:['showAllNotifications', 'index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete admin notifications'), only:['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:mark admin notifications'), only:['markAsRead', 'markAsUnread']),
      ];
    }

    // Method to retrieve all notifications
    public function showAllNotifications()
    {
        $notifications = [];

        // Fetch all notifications, you can paginate them as needed
        // $notifications = Notification::latest()->paginate(20);

        // Assuming you want to paginate through all users' notifications
        // foreach (User::paginate(10) as $user) {
        //     $notifications = array_merge($notifications, $user->notifications->toArray());
        // }

        // SweetAlert notification for loading notifications
        Alert::success('Notifications Loaded', 'All notifications have been successfully loaded.');

        // Use Laravel Notify to display a notification
        notify()->success('Notifications fetched successfully!');

        return view('admin.notifications.index', compact('notifications'));
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->delete();

            // SweetAlert success notification for deletion
            Alert::success('Deleted', 'Notification deleted successfully.');

            // Laravel Notify success notification
            notify()->success('Notification deleted successfully.');
        }

        return redirect()->back();
    }

    public function index(Request $request)
    {
        // Get the filter and sorting parameters from the request
        $readStatus = $request->input('read_status'); // 'read', 'unread', or null for all
        $sortOrder = $request->input('sort_order', 'desc'); // 'asc' or 'desc'
        $userName = $request->input('user_name'); // User name for filtering

        // Build the query
        $query = Notification::with('notifiable');

        // Apply the read status filter
        if ($readStatus === 'read') {
            $query->whereNotNull('read_at');
        } elseif ($readStatus === 'unread') {
            $query->whereNull('read_at');
        }

        // Apply the user name filter
        if ($userName) {
            $query->whereHas('notifiable', function ($q) use ($userName) {
                $q->where('name', 'like', '%' . $userName . '%');
            });
        }

        // Apply sorting
        $query->orderBy('created_at', $sortOrder);

        // Execute the query
        $notifications = $query->get();

        // SweetAlert for successful fetching
        Alert::success('Notifications Fetched', 'Notifications have been retrieved successfully.');
        notify()->success('Notifications fetched!');

        return view('admin.notifications.index', compact('notifications'));
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->read_at === null) {
            $notification->update(['read_at' => now()]);

            // SweetAlert success for marking as read
            Alert::success('Marked as Read', 'Notification has been marked as read.');

            // Laravel Notify success
            notify()->success('Notification marked as read!');

            return redirect()->route('admin.notifications')->with('status', 'Notification marked as read.');
        }

        // Notify if the notification was already read
        Alert::warning('Already Read', 'Notification was already read or not found.');
        notify()->warning('Notification already read or not found.');

        return redirect()->route('admin.notifications')->with('status', 'Notification was already read or not found.');
    }

    // Mark a notification as unread
    public function markAsUnread($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->read_at !== null) {
            $notification->update(['read_at' => null]);

            // SweetAlert success for marking as unread
            Alert::success('Marked as Unread', 'Notification has been marked as unread.');

            // Laravel Notify success
            notify()->success('Notification marked as unread!');

            return redirect()->route('admin.notifications')->with('status', 'Notification marked as unread.');
        }

        // Notify if the notification was already unread
        Alert::warning('Already Unread', 'Notification was already unread or not found.');
        notify()->warning('Notification already unread or not found.');

        return redirect()->route('admin.notifications')->with('status', 'Notification was already unread or not found.');
    }
}
