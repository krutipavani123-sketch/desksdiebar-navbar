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
        $users = User::with('roles.permissions')->get();

        return view('users.list', compact('users'));
    }


    public function create()
    {
        $roles = Role::all(); // user ને assign કરવા roles લાવવાના છે
        return view('users.create', compact('roles'));
        // return view('users.create'); // form page
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('users', 'roles'));
    }
    public function update(Request $request, $id)
    {

        $users = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|min:3|unique:users,email,' . $id,
            'role' => 'nullable|array'

        ]);

        if ($validator->passes()) {
            // $permission->update(['name'=> $request->name]);
            $users->name = $request->name;
            $users->email = $request->email;
            $users->save();
            $users->syncRoles($request->role ?? []);
            return redirect()->route('users.list', $id)
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
            'role' => 'nullable|array'
        ]);

        if ($validator->passes()) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);


            if ($request->has('role')) {
                $user->syncRoles($request->role);
            }


            return redirect()->route('users.list')->with('success', 'User Added');
        } else {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
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
