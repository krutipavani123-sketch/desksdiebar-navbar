<?php

namespace App\Http\Controllers;

use  App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use App\Services\LoginService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\LoginMail;
use Illuminate\Support\Facades\Mail;


class logincontroller extends Controller
{
    protected $LoginService;  // object 

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
        $user = User::create([
            "name" => $request->name,
            "email" =>  $request->email,
            "password" => Hash::make($request->password),
        ]);
        // $this->LoginService->register($request->only('name', 'email', 'password'));
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
            $user = Auth::user();
            $request->session()->regenerate();
            // $request->session()->save();
            Mail::to($user->email)->queue(new LoginMail($user));

            return redirect('welcome')->with('success', 'Login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  loginmail(Request $request)
    {
        return $this->LoginService->loginmail($request);
    }

    public function logout()
    {
        $this->LoginService->logout();
        return redirect()->route('login')->with('success', 'Logout');
    }
}
