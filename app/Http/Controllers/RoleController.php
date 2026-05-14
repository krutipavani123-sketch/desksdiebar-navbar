<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function addrole(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "name" => "required|unique:roles|min:3",
        ]);

        if ($validator->passes()) {
            $role = Role::create([
                "name" => $request->name,
            ]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.list')->with('success', 'Role Added');
        } else {
            return redirect()->route('roles.create')->with('error', 'Role Not Added');
        }
    }

    public function list(Request $request)
    {
        $roles = Role::all();
        return view('roles.rolelist', compact('roles'));
    }

    public function create(Request $request)
    {
        $permissions = Permission::all();
        return view('roles.createrole', compact('permissions'));
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::all();
        return view('roles.editrole', compact('permissions', 'hasPermissions', 'role'));
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.list')->with('success', 'Updated');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        if ($role) {
            return redirect()->route('roles.list')->with('success', 'Deleted');
        } else {
            return redirect()->route('roles.list')->with('Error', 'Not Deleted');
        }
    }
}
