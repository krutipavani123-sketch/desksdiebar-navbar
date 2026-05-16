<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function list()
    {
        //    $users = User::with('roles.permissions')->get();
        $users = User::with(['permissions', 'roles.permissions'])->get();

        return view('users.list', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();

        $permissions = Permission::all();
        return view('users.create', compact('roles', 'permissions'));
        // return view('users.create'); // form page
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        $roles = Role::all();
        $hasPermissions = $users->getPermissionNames();
        $permissions = Permission::all();
        return view('users.edit', compact('users', 'hasPermissions', 'permissions', 'roles'));
    }



    public function update(Request $request, $id)
    {

        $users = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|min:3|unique:users,email,' . $id,
            'permission' => 'nullable|array',
            'roles' => 'nullable|array'

        ]);

        if ($validator->passes()) {
            // $permission->update(['name'=> $request->name]);
            $users->name = $request->name;
            $users->email = $request->email;
            $users->save();
            if (!empty($request->permission)) {
                $users->syncPermissions($request->permission);
            } else {
                $users->syncPermissions([]);
            }

            if (!empty($request->roles)) {
                $users->syncRoles($request->roles);
            } else {
                $users->syncRoles([]);
            }
            return redirect()->route('users.list')
                ->with('success', 'Updated');
        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|min:3|unique:users,email',
            'password' => 'required',
            'roles' => 'nullable|array',
            'permission' => 'nullable|array',
        ]);

        if ($validator->passes()) {

            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);


            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $users->givePermissionTo($name);
                }
            }
            //dd($request->roles);
            if (!empty($request->roles)) {
                $users->syncRoles($request->roles);
            } else {
                $users->syncRoles([]);
            }
            return redirect()->route('users.list')->with('success', 'User Added');
        } else {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
    }



    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.list')->with('success', 'Deleted');
    }
}
    // public function edit($id)
    // {
    //     $users = User::findOrFail($id);
    //     $roles = Role::all();
    //     return view('users.edit', compact('users', 'roles'));
    // }
    // public function update(Request $request, $id)
    // {

    //     $users = User::findOrFail($id);

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|min:3|unique:permissions,name,' . $id

    //     ]);

    //     if ($validator->passes()) {
    //         // $permission->update(['name'=> $request->name]);
    //         $users->name = $request->name;
    //         $users->save();
    //         return redirect()->route('users.list', $id)
    //             ->with('success', 'Updated');
    //     } else {
    //         return redirect()->back()
    //             ->withInput()
    //             ->withErrors($validator);
    //     }
    // }
