<?php

namespace App\Http\Controllers;

use  App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use App\Services\LoginService;
use Illuminate\Support\Facades\Auth;

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
        //       dd($request->only('name', 'email', 'password'));
        return redirect('login')->with('success', 'Account created');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // $user = $this->LoginService->login($request->only('email', 'password'));

            if (!Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                throw new \Exception("Invalid credentials");
            }

            $request->session()->regenerate();
            $request->session()->save();
            // $user = User::where('email', $request->email)->first();
            // Auth::login($user);
            return redirect('welcome')->with('success', 'Login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
