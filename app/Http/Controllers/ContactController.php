<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert; // Add SweetAlert

class ContactController extends Controller
{

    public function __construct()
    {
        // Apply authentication middleware for all actions
        $this->middleware('auth');//->except(['index', 'store']); // Authentication required except for viewing and submitting the contact form

        // Apply permission middleware for viewing all contact messages
        $this->Middleware();
    }

    public static function Middleware(): array
    {
        return [

             new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view contacts'), only: ['showContacts']),
             new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:index contacts'), only: ['index']),
             new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:store contacts'), only: ['store']),
        ];
    }


    // Display the contact form
    public function index()
    {
        return view('home.contact');
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Store the contact message (optional)
        Contact::create($request->all());

        // Show SweetAlert success message
        Alert::success('Message Sent', 'Your message has been sent successfully!');
        notify()->success('Your message has been sent successfully!');
        // Redirect back to the form
        return redirect()->back();
    }

    // Method to display all contact messages to the admin
    public function showContacts()
    {
        $contacts = Contact::latest()->paginate(10); // Paginate contact messages
        return view('admin.contacts', compact('contacts'));
    }
}
