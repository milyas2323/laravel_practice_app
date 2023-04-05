<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Permission access|Permission create|Permission edit|Permission delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Permission create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Permission edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Permission delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'min:3']]);

        $permission = Permission::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return to_route('admin.permissions.index')->with('message', 'Permission Added Successfully!');
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();

        return view('admin.permissions.edit',  compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => ['required', 'min:3']]);

        $permission = Permission::find($permission->id);

        $permission->name       = $request['name'];
        $permission->guard_name = $request['guard_name'];

        $permission->save();

        return to_route('admin.permissions.index')->with('message', 'Permission Updated Successfully!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('message', 'Permission Deleted Successfully!');
    }

    public function assignRole(Request $request, Permission $permission)
    {
        if($permission->hasRole($request->role)){

            return back()->with('message', 'Role already Exists!');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role Assign Successfully!');

    }

    public function removeRole(Permission $permission, Role $role)
    {
        if($permission->hasRole($role)){

            $permission->removeRole($role);
            return back()->with('message', 'Role Removed Successfully!');
        }

        return back()->with('message', 'Role Not Exist!');
    }
}
