<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\loginmail;
use Illuminate\Support\Facades\Password;

class LoginService
{

    public function register(array $data)
    {
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data['password']),
        ]);


        // if ($user->id == 1) {
        //     $user->assignRole('admin');
        // } else {
        //     $user->assignRole("customer");
        // }
        $user->sendEmailVerificationNotification();



        return $user;
    }

    public function login(Request $request) {}

    public function loginmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }
}
