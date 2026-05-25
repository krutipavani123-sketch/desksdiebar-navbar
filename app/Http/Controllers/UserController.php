<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

function clearDashboardCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('admindashboard_stats');
        Cache::forget('leaderdashboard_stats');
        Cache::forget('agentdashboard_stats');
        Cache::forget('customerdashboard_tasks');
    }
    public function list()
    {
        //    $users = User::with('roles.permissions')->get();
        $users = User::with(['permissions', 'roles.permissions', 'teams'])->get();

        if (request()->filled('search')) {
            $search = request()->search;
            $users->where('name', 'like', "%{$search}%");
        }
        //$users = $users->get
       // $users = User::with(['permissions', 'roles.permissions', 'teams'])->get();

        $teams = Team::all();

           $this->clearDashboardCache();
        return view('users.list', compact('users', 'teams'));
    }


    public function create()
    {
        $roles = Role::all();
        $teams = Team::all();
        $permissions = Permission::all();
        return view('users.create', compact('roles', 'permissions', 'teams'));
        // return view('users.create'); // form page
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        $roles = Role::all();
        $teams = Team::all();
        $hasPermissions = $users->getPermissionNames();
        $permissions = Permission::all();
        return view('users.edit', compact('users', 'hasPermissions', 'permissions', 'roles', 'teams'));
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
            //$users->team_id = $request->team_id;

               $this->clearDashboardCache();
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
            //'team_id' => 'nullable|exists:teams,id',
        ]);
   $this->clearDashboardCache();
        if ($validator->passes()) {

            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
              //  'team_id' => $request->team_id,
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
           $this->clearDashboardCache();
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
