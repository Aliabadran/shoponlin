<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:view role'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:create role'), only: ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:update role'), only: ['update', 'edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:delete role'), only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::get();
        return view('role-permission.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('role-permission.role.create');
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        // SweetAlert for success
        Alert::success('Success', 'Role Created Successfully');
        drakify('success');
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        return view('role-permission.role.edit', ['role' => $role]);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);

        $role->update([
            'name' => $request->input('name')
        ]);

        // SweetAlert for success
        Alert::success('Success', 'Role Updated Successfully');
        drakify('info');
        return redirect('roles');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();

        // SweetAlert for success
        Alert::success('Deleted', 'Role Deleted Successfully');
        drakify('error') ;
        return redirect('roles');
    }

    /**
     * Show the form for adding permissions to a role.
     */
    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Assign permissions to the specified role.
     */
    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        // SweetAlert for success
        Alert::success('Success', 'Permissions added to role');
        notify()->success('Permissions added to role');
        return redirect()->back();
    }
}
