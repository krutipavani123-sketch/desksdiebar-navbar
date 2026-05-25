<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{

    protected $roleservice;     //object
    public function __construct(RoleService $roleservice)
    {
        $this->roleservice = $roleservice;
    }

    function clearDashboardCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('admindashboard_stats');
        Cache::forget('leaderdashboard_stats');
        Cache::forget('agentdashboard_stats');
        Cache::forget('customerdashboard_tasks');
    }


    public function addrole(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "name" => "required|unique:roles|min:3",
            'permission' => 'nullable|array',   //optional or array
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //  if (!empty($request->permission)) {
        //              foreach ($request->permission as $name) {
        //             $role->givePermissionTo($name);
        //         }
        // $role = $this->roleservice->addrole($request->all());
        // $permissions = $request->input('permission', []);


        // if ($role) {
        //     $role->syncPermissions($permissions);
        // }
           $this->clearDashboardCache();
        $this->roleservice->addrole($request->all());
        return redirect()->route('roles.list')->with('success', 'Role Added');
    }

    // if ($validator->passes()) {
    //     $role = Role::create([
    //         "name" => $request->name,
    //     ]);


    // }
    // return redirect()->route('roles.list')->with('success', 'Role Added');
    // } else {
    //     return redirect()->route('roles.create')->with('error', 'Role Not Added');
    // }




    public function list(Request $request)
    {
           $this->clearDashboardCache();
        return $this->roleservice->list();
    }
    // public function list(Request $request)
    // {
    //     $roles = Role::all();
    //     return view('roles.rolelist', compact('roles'));
    // }

    public function create(Request $request)
    {
           $this->clearDashboardCache();
        return $this->roleservice->create();
        // $permissions = Permission::all();
        // return view('roles.createrole', compact('permissions'));
    }
    public function edit($id)
    {
        $roles = Role::findOrFail($id);
        $hasPermissions = $roles->permissions->pluck('name');    //just name give /return
        $permissions = Permission::all();
        return view('roles.editrole', compact('permissions', 'hasPermissions', 'roles'));
    }
    public function update(Request $request, $id)
    {
        $roles = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'

            //unique:table,column,ignore_id,id_column
        ]);
   $this->clearDashboardCache();
        if ($validator->passes()) {
            $roles->name = $request->name;
            $roles->save();

            if (!empty($request->permission)) {    // come from form checkbx input
                $roles->syncPermissions($request->permission);    //remove old , add new
            } else {
                $roles->syncPermissions([]);   // remove all
            }
            return redirect()->route('roles.list')->with('success', 'Updated');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function delete($id)
    {
        $roles = Role::findOrFail($id);
        $roles->delete();
           $this->clearDashboardCache();
        if ($roles) {
            return redirect()->route('roles.list')->with('success', 'Deleted');
        } else {
            return redirect()->route('roles.list')->with('Error', 'Not Deleted');
        }
    }
}
