<?php

namespace App\Http\Controllers;

use App\Models\Permission;

use  App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{

    protected $permissionservice;   //object


    function clearDashboardCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('admindashboard_stats');
        Cache::forget('leaderdashboard_stats');
        Cache::forget('agentdashboard_stats');
        Cache::forget('customerdashboard_tasks');
    }

    public function __construct(PermissionService $permissionservice)
    {
        $this->permissionservice =  $permissionservice;
    }
    public function permissionadd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
   $this->clearDashboardCache();
        $this->permissionservice->permissionadd(request()->all());

        return redirect()->route('permissions.permissionlist')->with('success', 'Permission Added');
        // if ($validator->passes()) {
        //     Permission::create([
        //         'name' => $request->name,
        //         'guard_name' => 'web',
        //     ]);
        // return redirect()->route('permissions.permissionlist')->with('success', 'Permission Added');
        // } else {
        //     return redirect()->route('permissions.permissioncreate')
        //         ->withErrors($validator)
        //         ->withInput()
        //         ->with('error', 'Permission validation failed.');
        // }
        // $this-> PermissionService->addPermission(request()->all());
        // return redirect()->route("permissions.permissionadd");
        // return view('permissions.permissionadd');
        return redirect()->back()->with('success', 'Permission created successfully!');
    }



    public function permissioncreate()
    {

        return view('permissions.permissioncreate');
    }

    public function permissionlist()
    {

        // $permissions = Permission::all();
           $this->clearDashboardCache();
        return $this->permissionservice->permissionlist();
        //  return view('permissions.permissionlist', compact('permissions'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permissions.permissionedit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id

        ]);
   $this->clearDashboardCache();
        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('permissions.permissionlist')->with('success', 'Updated');
        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
          $this->clearDashboardCache();
        return redirect()->route('permissions.permissionlist')->with('success', 'Deleted');
    }
}
