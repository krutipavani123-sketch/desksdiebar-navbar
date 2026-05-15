<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

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



// Route::get('roles/createrole', [RoleController::class, 'create'])->name('roles.create');
// Route::post('roles/addrole', [RoleController::class, 'addrole'])->name('roles.addrole');
// Route::get('roles/rolelist', [RoleController::class, 'list'])->name('roles.list');
// Route::get('roles/editrole/{id}', [RoleController::class, 'edit'])->name('roles.edit');
// Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
// Route::get('roles/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');


Route::get('roles/createrole', [RoleController::class, 'create'])->name('roles.create');
Route::post('roles/addrole', [RoleController::class, 'addrole'])->name('roles.addrole');
Route::get('roles/rolelist', [RoleController::class, 'list'])->name('roles.list');
Route::get('roles/editrole/{id}', [RoleController::class, 'edit'])->name('roles.edit');
Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::get('roles/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');


Route::get('users/create', [UserController::class, 'create'])->name('users.create');

Route::post('users/store', [UserController::class, 'store'])->name('users.store');

Route::get('users/list', [UserController::class, 'list'])->name('users.list');

Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

Route::put('users/update/{id}', [UserController::class, 'update'])->name('users.update');

Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');


Route::get('customer/createticket', [TicketController::class, 'create'])->name('customer.createticket');
Route::post('customer/addticket', [TicketController::class, 'addticket'])->name('customer.addticket');

//Route::view('customer/createticket', 'customer.createticket');

Route::get('customer/ticketlist', [TicketController::class, 'ticketlist'])->name('customer.ticketlist');

Route::get('customer/editticket/{id}', [TicketController::class, 'edit'])->name('customer.edit');
Route::put('customer/updateticket/{id}', [TicketController::class, 'update'])->name('customer.update');
Route::get('customer/deleteticket/{id}', [TicketController::class, 'delete'])->name('customer.delete');
