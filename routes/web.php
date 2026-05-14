<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;

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


// Route::get('create',     [PermissionController::class, 'create'])->name('create');


Route::get('permissions/permissioncreate', [PermissionController::class, 'permissioncreate'])->name('permissions.permissioncreate');

Route::post('permissions/permissionadd', [PermissionController::class, 'permissionadd'])->name('permissions.permissionadd');

Route::get('permissions/permissionlist', [PermissionController::class, 'permissionlist'])->name('permissions.permissionlist');

Route::get('permissions/permissionedit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');

Route::put('update/{id}', [PermissionController::class, 'update'])->name('permissions.update');

Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');



//Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
// Route::post('roles/addrole', [RoleController::class, 'addrole'])->name('roles.addrole');
// Route::get('roles/list', [RoleController::class, 'list'])->name('roles.list');
// Route::get('roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
// Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
