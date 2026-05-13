<?php

namespace App\Http\Controllers;

use  App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use App\Services\LoginService;

class logincontroller extends Controller
{
    protected $LoginService;

    public function __construct(LoginService $LoginService)
    {
        $this->LoginService = $LoginService;
    }

    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $this->LoginService->register($request->only('name', 'email', 'password'));
        return redirect('login')->with('success', 'Account created');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = $this->LoginService->login($request->only('email', 'password'));

            return redirect('welcome')->with('success', 'Login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
