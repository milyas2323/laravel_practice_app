<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Role access|Role create|Role edit|Role delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Role create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Role edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Role delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //$roles = Role::whereNotIn('name', ['admin'])->get();
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions_admin = Permission::where('guard_name', 'admin')->get();
        $permissions_web   = Permission::where('guard_name', 'web')->get();

        return view('admin.roles.create',  compact('permissions_admin', 'permissions_web'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'min:3']]);

        $role = Role::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name
        ]);

        if($request->guard_name =="admin"){

            $role->syncPermissions($request->permissions_admin);

        }else{

            $role->syncPermissions($request->permissions_web);
        }

        return to_route('admin.roles.index')->with('message', 'Role Added Successfully!');;
    }

    public function edit(Role $role)
    {
        $permissions_admin = Permission::where('guard_name', 'admin')->get();
        $permissions_web   = Permission::where('guard_name', 'web')->get();

        return view('admin.roles.edit',  compact('role', 'permissions_admin', 'permissions_web'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => ['required', 'min:3']]);

        $role = Role::find($role->id);

        $role->name       = $request['name'];
        $role->guard_name = $request['guard_name'];

        $role->save();

        if($request->guard_name =="admin"){

            $role->syncPermissions($request->permissions_admin);

        }else{

            $role->syncPermissions($request->permissions_web);
        }

        return to_route('admin.roles.index')->with('message', 'Role Updated Successfully!');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('message', 'Role Deleted Successfully!');
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){

            return back()->with('message', 'Permission already Exists!');
        }

        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission Assign Successfully!');

    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){

            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission Revoked Successfully!');
        }

        return back()->with('message', 'Permission Not Exist!');
    }
}
