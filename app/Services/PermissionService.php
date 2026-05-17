<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    /**
     * Create a new class instance.
     */

    public function permissionadd(array $data)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|unique:permissions|min:3',

        // ]);


        Permission::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);
        //     return redirect()->route('permissions.permissionlist')->with('success', 'Permission Added');
        // } else {
        //     return redirect()->route('permissions.permissioncreate')
        //         ->withErrors($validator)
        //         ->withInput()
        //         ->with('error', 'Permission validation failed.');
        // }

    }
    public function permissionlist()
    {

        //     $users = Cache::remember('users', $seconds, function () {
        //     return DB::table('users')->get();
        // });


        // $permissions = Permission::all();
        $query = Permission::query(); // query builder (like select query)

        if (request()->filled('search')) {
            $search = request()->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $permissions = $query->get();

        return view('permissions.permissionlist', compact('permissions'));
    }
}

    //   $permissions = Cache::remember('users', 3600, function () {
    //             return \App\Models\Permission::all();
    //         });