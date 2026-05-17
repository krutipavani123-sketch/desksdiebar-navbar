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



        return $user;
    }

    public function login(array $data) {}

    public function loginmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
        // ->middleware('guest')->name('password.email');
    }

    public function logout()
    {
        Auth::logout();
    }
}
