<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('web')->group(function () {

    Route::get('login', [logincontroller::class, 'showLogin'])->name('login');
    Route::post('login', [logincontroller::class, 'login']);
    Route::get('register', [logincontroller::class, 'showRegister']);
    Route::post('register', [logincontroller::class, 'register']);

    Route::get('welcome', [WelcomeController::class, 'welcome']);
    Route::middleware('auth')->group(function () {
        Route::get('profile', [ProfileController::class, 'profile']);
    });
});

    // Wrap all your application routes inside this group
// Route::middleware(['web'])->group(function () {

//     Route::get('login', [logincontroller::class, 'showLogin'])->name('login');
//     Route::get('register', [logincontroller::class, 'showRegister']);
//     Route::post('register', [logincontroller::class, 'register']);
//     Route::post('login', [logincontroller::class, 'login']);

//     Route::get('welcome', [WelcomeController::class, 'welcome'])->middleware('auth');
//     Route::get('profile', [ProfileController::class, 'profile'])->middleware('auth');
// });
