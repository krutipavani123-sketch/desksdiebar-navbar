<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use  App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use App\Services\LoginService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\LoginMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
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
        $user->assignRole('customer');


     //   Auth::login($user);

        //  $user->sendEmailVerificationNotification(); 

        // return redirect()->route('verification.notice')
        //     ->with('success', 'Check your email for verification link');


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
            // $user = Auth::user();
            // if (!$user->hasVerifiedEmail()) {

            //     Auth::logout();

            //     return redirect()->back()
            //         ->with('error', 'Please verify your email first');
            // }

            $user = Auth::user();

         //   event(new Registered($user));


            $request->session()->regenerate();
            $request->session()->save();
            Mail::to($user->email)->queue(new LoginMail($user));

            return redirect('dashboard')->with('success', 'Login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // public function  loginmail(Request $request)
    // {
    //     return $this->LoginService->loginmail($request);
    // }

    public function logout()
    {
        $this->LoginService->logout();
        return redirect()->route('login')->with('success', 'Logout');
    }

    public function resetpassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        //token verify , email match , password change
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            //find user
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
        //check reset success or not
        return $status === Password::PASSWORD_RESET
            ? redirect('/dashboard')->with('success', 'Password reset successful!')
            : back()->withErrors(['email' => __($status)]);
    }


    //     public function resetpassword(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed',
    //     ]);

    //     $status = Password::reset(
    //         $request->only('email', 'password', 'password_confirmation', 'token'),
    //         function ($user, $password) {
    //             $user->password = bcrypt($password);
    //             $user->save();
    //         }
    //     );

    //     return $status === Password::PASSWORD_RESET
    //         ? redirect('/dashboard')->with('success', 'Password reset successful!') // go to dashboard
    //         : back()->withErrors(['email' => __($status)]);
    // }

    //     public function forgotpassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status === Password::RESET_LINK_SENT
    //         ? back()->with('status', 'Reset link sent to your email.')
    //         : back()->withErrors(['email' => 'Email not found.']);
    // }


    public function forgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        //check exists email and send reset mail ,genrate password token
        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        // check successfully sent link
        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent to your email')
            : back()->withErrors(['email' => 'Email not found']);
    }

    public function verifynotice()
    {
        return view('auth.verify-email');
    }

    public function verifyemail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('login')->with('success', 'Email Verify Successfully');
    }

    public function resendverification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent');
    }
}
