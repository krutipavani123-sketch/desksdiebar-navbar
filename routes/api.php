<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

//session enable ,csrf protection,login maintain
Route::middleware('web')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister']);
    Route::post('register', [AuthController::class, 'register']);
});
