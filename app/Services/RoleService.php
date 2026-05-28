<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleService
{


    public function addrole(array $data)
    {
        // $validator = Validator::make(request()->all(), [
        //     "name" => "required|unique:roles|min:3",
        // ]);


        $roles = Role::create([
            "name" => $data['name'],
            'guard_name' => 'web'
        ]);


        if (!empty($data['permission'])) {
            foreach ($data['permission'] as $name) {
                $roles->givePermissionTo($name);
            }
        }
        return $roles;
        // if (!empty($request->permission)) {
        //     foreach ($request->permission as $name) {
        //         $role->givePermissionTo($name);
        //     }
        // }
        //        return redirect()->route('roles.list')->with('success', 'Role Added');

        //      return redirect()->route('roles.create')->with('error', 'Role Not Added');

    }

    public function list()
    {

        $query = Role::query();    // query builder(like select query)
        if (request()->filled('search')) {
            $search = request()->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->get();

        return view('roles.rolelist', compact('roles'));
    }



    public function create()
    {
        $permissions = Permission::all();
        return view('roles.createrole', compact('permissions'));
    }
}
