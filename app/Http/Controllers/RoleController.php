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
    public function addrole()
    {
        $permissions = Permission::all();
        return view('roles.addrole', compact('permissions'));
    }
}
