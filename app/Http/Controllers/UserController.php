<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view user'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create user'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update user'), only: ['update', 'edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete user'), only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::get();
        return view('role-permission.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role to user
      // $user->assignRole($request->role);
      $user->assignRole('user');

        $user->sendEmailVerificationNotification();
        // SweetAlert for success
        Alert::success('Success', 'User created successfully with roles');

        return redirect('/users');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        // SweetAlert for success
        Alert::success('Success', 'User updated successfully with roles');

        return redirect('/users');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        // SweetAlert for success
        Alert::success('Success', 'User deleted successfully');

        return redirect('/users');
    }
}
