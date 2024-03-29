<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AllowedipController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
use App\Models\Notes;



// Route::group(['middleware' => ['allowedIP']], function () {

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/dashboard');
    }
    return redirect()->intended('/login');
});

/* Dashboard */
Route::get('/dashboard', function () {
    return view('layouts.index', [
        'title' => 'dashboard',
    ]);
})->middleware('auth');

/* Login & Logout */
Route::get('/login', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->Middleware('auth');


/* Middleware */
Route::middleware(['auth'])->group(function () {
    /* Loader */
    Route::get('/codetest', function () {
        return view('layouts.loader');
    })->name('codetest');

    /* Top Nav */
    Route::get('/topnav', function () {
        $totalnote = Notes::count();
        return view('layouts.top_nav', ['totalnote' => $totalnote]);
    })->name('topnav');

    /* Side Nav */
    Route::get('/sidenav', function () {
        return view('layouts.side_nav');
    })->name('sidenav');

    /* Notes */
    Route::get('/notes', [NotesController::class, 'index']);
    Route::get('/notes/add', [NotesController::class, 'create']);
    Route::get('/notes/edit/{id}', [NotesController::class, 'edit']);
    Route::post('/notes/store', [NotesController::class, 'store']);
    Route::post('/notes/update', [NotesController::class, 'update']);
    Route::delete('/notes/delete', [NotesController::class, 'destroy']);
    Route::get('/notes/view/{id}', [NotesController::class, 'views']);

    /* Profile */
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile/update/', [UserController::class, 'updateProfile']);

    /*-- User --*/
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/add', [UserController::class, 'create']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::delete('/user/delete', [UserController::class, 'destroy']);
    Route::get('/user/view/{id}', [UserController::class, 'views']);

    /*--  Allowed IP --*/
    Route::get('/allowedip', [AllowedipController::class, 'index']);
    Route::get('/allowedip/add', [AllowedipController::class, 'create']);
    Route::get('/allowedip/edit/{id}', [AllowedipController::class, 'edit']);
    Route::post('/allowedip/store', [AllowedipController::class, 'store']);
    Route::post('/allowedip/update', [AllowedipController::class, 'update']);
    Route::delete('/allowedip/delete', [AllowedipController::class, 'destroy']);
    Route::get('/allowedip/view/{id}', [AllowedipController::class, 'views']);

    /*-- Agents --*/
    Route::get('/agents', [AgentsController::class, 'index']);
    Route::get('/agents/add', [AgentsController::class, 'create']);
    Route::get('/agents/edit/{id}', [AgentsController::class, 'edit']);
    Route::post('/agents/store', [AgentsController::class, 'store']);
    Route::post('/agents/update', [AgentsController::class, 'update']);
    Route::delete('/agents/delete', [AgentsController::class, 'destroy']);
    Route::get('/agents/view/{id}', [AgentsController::class, 'views']);

    /*-- Players --*/
    Route::get('/players', [PlayersController::class, 'index']);
    Route::get('/players/add', [PlayersController::class, 'create']);
    Route::get('/players/edit/{id}', [PlayersController::class, 'edit']);
    Route::post('/players/store', [PlayersController::class, 'store']);
    Route::post('/players/update', [PlayersController::class, 'update']);
    Route::delete('/players/delete', [PlayersController::class, 'destroy']);
    Route::get('/players/view/{id}', [PlayersController::class, 'views']);

    /*-- Transactions --*/
    Route::get('/transactions', [TransactionsController::class, 'index']);

    /*-- Settings --*/
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::get('/settings/add', [SettingsController::class, 'create']);
    Route::get('/settings/edit/{id}', [SettingsController::class, 'edit']);
    Route::post('/settings/store', [SettingsController::class, 'store']);
    Route::post('/settings/update', [SettingsController::class, 'update']);
    Route::delete('/settings/delete', [SettingsController::class, 'destroy']);
    Route::get('/settings/view/{id}', [SettingsController::class, 'views']);
});
// });
