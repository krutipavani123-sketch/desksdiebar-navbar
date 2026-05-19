<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;

use Dom\Comment;

Route::get('/', function () {
    return view('welcome');
});
// Route::middleware(['auth'])->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->name('dashboard');

// });
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::post('/loginmail', [logincontroller::class, 'loginmail'])->name('loginmail');


Route::middleware('web')->group(function () {

    Route::get('login', [logincontroller::class, 'showLogin'])->name('login');
    Route::post('login', [logincontroller::class, 'login']);
    Route::get('register', [logincontroller::class, 'showRegister']);
    Route::post('register', [logincontroller::class, 'register']);

    Route::get('welcome', [WelcomeController::class, 'welcome']);
    Route::middleware('auth')->group(function () {
        Route::get('profile', [ProfileController::class, 'profile']);
        Route::get('logout', [logincontroller::class, 'logout']);
    });
});


// Route::get('create',     [PermissionController::class, 'create'])->name('create');


Route::get('permissions/permissioncreate', [PermissionController::class, 'permissioncreate'])->name('permissions.permissioncreate');

Route::post('permissions/permissionadd', [PermissionController::class, 'permissionadd'])->name('permissions.permissionadd');

Route::get('permissions/permissionlist', [PermissionController::class, 'permissionlist'])->name('permissions.permissionlist');

Route::get('permissions/permissionedit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');

Route::put('update/{id}', [PermissionController::class, 'update'])->name('permissions.update');

Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('delete');






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



Route::get('show', [TicketController::class, 'show'])->name('show');

Route::get('customer/createticket', [TicketController::class, 'create'])->name('customer.createticket');

Route::post('customer/addticket', [TicketController::class, 'addticket'])->name('customer.addticket');

Route::get('customer/ticketlist', [TicketController::class, 'ticketlist'])->name('customer.ticketlist');

Route::get('customer/editticket/{id}', [TicketController::class, 'edit'])->name('customer.edit');
Route::put('customer/updateticket/{id}', [TicketController::class, 'update'])->name('customer.update');
Route::get('customer/deleteticket/{id}', [TicketController::class, 'delete'])->name('customer.delete');

Route::get('customer/resolve/{id}', [TicketController::class, 'resolve'])
    ->name('customer.resolve');

Route::post('customer/resolve/update/{id}', [TicketController::class, 'updateResolve'])
    ->name('customer.resolve.update');


Route::post('customer/updatestatus/{id}', [TicketController::class, 'updatestatus'])
    ->name('customer.updatestatus');


Route::post('customer/assignticket', [TicketController::class, 'assignticket'])->name('customer.assignticket');



Route::get('team/teamcreate', [TeamController::class, 'create'])->name('team.create');

Route::post('team/addteam', [TeamController::class, 'addteam'])->name('team.addteam');

Route::get('team/listteam', [TeamController::class, 'list'])->name('team.list');

Route::get('team/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');

Route::put('team/update/{id}', [TeamController::class, 'update'])->name('team.update');

Route::get('team/delete/{id}', [TeamController::class, 'delete'])->name('team.delete');


Route::get('show/{id}', [CommentController::class, 'show'])
    ->name('customer.show');

Route::get('comment/{id}', [CommentController::class, 'create'])
    ->name('customer.comment');

Route::post('addcomment', [CommentController::class, 'addcomment'])->name('addcomment');

Route::get('commentlist/{id}', [CommentController::class, 'commentlist'])
    ->name('customer.commentlist');

Route::get('delete/{id}', [CommentController::class, 'delete'])->name('delete');

Route::get('customer/editcomment/{id}', [CommentController::class, 'edit'])->name('edit');
Route::post('update/{id}', [CommentController::class, 'update'])->name('update');
