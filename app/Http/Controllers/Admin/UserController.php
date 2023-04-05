<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:User access|User create|User edit|User delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:User create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:User edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:User delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
        ]);

        $user->syncRoles($request->roles);

        return to_route('admin.users.index')->with('message', 'User Added Successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();

        return view('admin.users.edit',  compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return to_route('admin.users.index')->with('message', 'User Updated Successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('message', 'User Deleted Successfully!');
    }

    public function show(User $user)
    {
        $roles       = Role::all();
        $permissions = Permission::all();

        return view('admin.users.role',  compact('user', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        if($user->hasRole($request->role)){

            return back()->with('message', 'User Role already Exists!');
        }

        $user->assignRole($request->role);
        return back()->with('message', 'User Role Assign Successfully!');

    }

    public function removeRole(User $user, Role $role)
    {
        if($user->hasRole($role)){

            $user->removeRole($role);
            return back()->with('message', 'User Role Removed Successfully!');
        }

        return back()->with('message', 'Role Not Exist!');
    }


    public function givePermission(Request $request, User $user)
    {
        if($user->hasPermissionTo($request->permission)){

            return back()->with('message', 'User Permission already Exists!');
        }

        $user->givePermissionTo($request->permission);
        return back()->with('message', 'User Permission Assign Successfully!');

    }

    public function revokePermission(User $user, Permission $permission)
    {
        if($user->hasPermissionTo($permission)){

            $user->revokePermissionTo($permission);
            return back()->with('message', 'User Permission Revoked Successfully!');
        }

        return back()->with('message', 'User Permission Not Exist!');
    }
}
