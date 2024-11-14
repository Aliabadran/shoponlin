<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NotificationContent;
use App\Jobs\SendOfferNotificationJob;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert; // Add SweetAlert

class NotificationContentController extends Controller
{
    public static function middleware(): array
    {
        return [

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view notificationContent'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:show notificationContent'), only: ['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create notificationContent'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update notificationContent'), only: ['update', 'edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete notificationContent'), only: ['destroy']),
        ];
    }

    public function index()
    {
        $notifications = NotificationContent::all();
        return view('notifications.index', compact('notifications'));
    }
    public function show($id)
    {
        $notification = NotificationContent::findOrFail($id);
        return view('notifications.show', compact('notification'));
    }
    public function create()
    {
        return view('notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'url' => 'required',
        ]);

        $notificationContent = NotificationContent::create($request->all());

        // Dispatch job to send notifications to users
        SendOfferNotificationJob::dispatch($notificationContent->id);



     Alert::success('Message Sent',  'Notification created and sent successfully.');
      notify()->success('Your message has been sent successfully!');
        return redirect()->route('notificationsOffer.index')->with('success', 'Notification created and sent successfully.');
    }

        // app/Http/Controllers/NotificationContentController.php

        public function edit(NotificationContent $notificationsOffer)
        {
            return view('notifications.edit', compact('notificationsOffer'));
        }


        public function update(Request $request, NotificationContent $notificationsOffer)
        {
            $request->validate([
                'title' => 'required',
                'message' => 'required',
                'url' => 'required',
            ]);

            // Update the notification content with the new data
            $notificationsOffer->update($request->all());


                // Dispatch job to send the updated notification to users
            // SendOfferNotificationJob::dispatch($notification->id);
            SendOfferNotificationJob::dispatch($notificationsOffer->id);

            Alert::success('Notification updated', 'Notification updated successfully!');

            // Laravel Notify success notification
            notify()->success('Notification updated successfully!');

            // Redirect to the index page with a success message
            return redirect()->route('notificationsOffer.index')->with('success', 'Notification updated successfully.');
        }


            public function destroy(NotificationContent $notificationsOffer)
            {
                $notificationsOffer->delete();
                Alert::info('Notification', 'Notification deleted successfully.');
                notify()->success('Here is a success message!');
                return redirect()->route('notificationsOffer.index')->with('success', 'Notification deleted successfully.');
            }


}

