<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:

            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view permission'), only:['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create permission'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update permission'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete permission'), only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role-permission.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        Alert::success('Success', 'Permission Created Successfully'); // SweetAlert for success
        smilify('success', 'Permission Created Successfully');
        return redirect('permissions');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        Alert::success('Success', 'Permission Updated Successfully'); // SweetAlert for success
        drakify('success');
        return redirect('permissions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();

        Alert::success('Deleted', 'Permission Deleted Successfully'); // SweetAlert for deletion
        smilify('success', 'Permission Deleted Successfully');
        return redirect('permissions');
    }
}
