<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {  $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Convert email to lowercase manually
    $email = strtolower($request->input('email'));

    // Create the user
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $email,
        'password' => Hash::make($request->input('password')),
    ]);

      // Assign the default 'user' role to the newly registered user
      $user->assignRole('user');

      // Fire the Registered event
      event(new Registered($user));

      // Log in the newly registered user
      Auth::login($user);

      // Flash success message
      session()->flash('success', 'Registration successful! Welcome to the dashboard.');

      // SweetAlert success message
      alert()->success('Success', 'Registration successful! Check your email to verify your account.');

      // Redirect to the intended page
    return redirect()->intended(route('home', absolute: false));
    }
}
