<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;

Route::get('/', function () {
    return view('welcome');
});


Route::get('register', [logincontroller::class, 'register']);
Route::get('login', [logincontroller::class, 'login']);
Route::post('register', [logincontroller::class, 'register']);
Route::post('login', [logincontroller::class, 'login']);



Route::get('login', [logincontroller::class, 'showLogin']);
Route::get('register', [logincontroller::class, 'showRegister']);


Route::get('welcome', [logincontroller::class, 'welcome']);
