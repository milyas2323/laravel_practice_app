<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin access|Admin create|Admin edit|Admin delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Admin create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Admin edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Admin delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $admins = Admin::all();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:admins',
            'password'=>'required|confirmed'
        ]);

        $admin = Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
        ]);

        $admin->syncRoles($request->roles);

        return to_route('admin.admins.index')->with('message', 'Admin Added Successfully!');
    }

    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.admins.edit',  compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:admins,email,'.$admin->id.',id',
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $admin->update($validated);

        $admin->syncRoles($request->roles);

        return to_route('admin.admins.index')->with('message', 'Admin Updated Successfully!');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return back()->with('message', 'Admin Deleted Successfully!');
    }
}
