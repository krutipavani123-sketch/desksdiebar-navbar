<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class LoginService
{

    public function register(array $data)
    {
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data['password']),
        ]);


        if ($user->id == 1) {
            $user->assignRole('admin');
        } else {
            $user->assignRole("customer");
        }



        return $user;
    }

    public function login(array $data)
    {
        
    }
    public function logout()
    {
        Auth::logout();
    }
}
