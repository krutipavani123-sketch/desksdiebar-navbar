<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function welcome()
    {
        return view('welcome', [
            'user' => Auth::user() // Pass user variables explicitly down to view layouts
        ]);
    }
}
