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
use App\Http\Controllers\DepoWdController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositdsController;
use App\Http\Controllers\WithdrawdsController;
use App\Http\Controllers\ManualdsController;
use App\Http\Controllers\HistorydsController;
use App\Http\Controllers\MemberlistdsController;
use App\Http\Controllers\HistorygamedsController;
use App\Http\Controllers\OutstandingdsController;
use App\Http\Controllers\ReferraldsController;
use App\Http\Controllers\BankdsController;
use App\Http\Controllers\MemodsController;
use App\Http\Controllers\AgentdsController;
use App\Http\Controllers\EventdsController;
use App\Http\Controllers\ApksettingdsController;
use App\Http\Controllers\AllowedipdsController;
use App\Http\Controllers\MemotouserdsController;
use App\Http\Controllers\UsermanagementdsController;
use App\Http\Controllers\Menu2Controller;
use App\Models\DepoWd;
use App\Models\Notes;



// Route::group(['middleware' => ['allowedIP']], function () {

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/deposit');
    }
    return redirect()->intended('/login');
});

/* Dashboard */
Route::get('/dashboard', function () {
    return view('layouts.index', [
        'title' => 'dashboard',
        'totalnote' => 0
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
    // Route::get('/settings', [SettingsController::class, 'index']);
    // Route::get('/settings/add', [SettingsController::class, 'create']);
    // Route::get('/settings/edit/{id}', [SettingsController::class, 'edit']);
    // Route::post('/settings/store', [SettingsController::class, 'store']);
    // Route::post('/settings/update', [SettingsController::class, 'update']);
    // Route::delete('/settings/delete', [SettingsController::class, 'destroy']);
    // Route::get('/settings/view/{id}', [SettingsController::class, 'views']);

    /*-- Deposit --*/
    Route::get('/deposit', [DepoWdController::class, 'indexdeposit']);
    Route::get('/history/{jenis?}', [DepoWdController::class, 'indexhistory'])->name('history');
    Route::get('/withdrawal', [DepoWdController::class, 'indexwithdrawal']);
    Route::post('/reject', [DepoWdController::class, 'reject']);
    Route::post('/approve', [DepoWdController::class, 'approve']);
    Route::get('/manual', [DepoWdController::class, 'indexmanual']);
    Route::post('/manual/add', [DepoWdController::class, 'storemanual']);

    /*-- Member --*/
    Route::get('/member', [MemberController::class, 'index']);
    Route::get('/member/add', [MemberController::class, 'create']);
    Route::get('/member/edit/{id}', [MemberController::class, 'edit']);
    Route::post('/member/store', [MemberController::class, 'store']);
    Route::post('/member/updatemember', [MemberController::class, 'updateMember']);
    Route::post('/member/updatepassword', [MemberController::class, 'updatePassword']);
    Route::post('/member/updateplayer', [MemberController::class, 'updatePlayer']);

    /*-- APK --*/
    Route::get('/setting', [SettingsController::class, 'indexsetting']);
    Route::get('/event', [SettingsController::class, 'indexevent']);
    Route::get('/notice', [SettingsController::class, 'indexnotice']);

    /*-- Bank --*/
    Route::get('/bank', [BankController::class, 'index']);

    /*-- Dashboard --*/
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*-- Despositds --*/
    Route::get('/depositds/{jenis}', [DepositdsController::class, 'index']);
    Route::get('/getDataHistory/{username}/{jenis}', [DepositdsController::class, 'getDataHistory']);
    Route::get('/getbalance/{username}', [DepoWdController::class, 'getBalancePlayer']);
    Route::get('/datacountwdp', [DepoWdController::class, 'getCountDataDPW']);


    /*-- Withdrawds --*/
    Route::get('/withdrawds', [WithdrawdsController::class, 'index']);

    /*-- Manualds --*/
    Route::get('/manualds', [ManualdsController::class, 'index'])->name('manualds');

    /*-- Historyds --*/
    Route::get('/historyds', [HistorydsController::class, 'index']);

    /*-- Memberlistds --*/
    Route::get('/memberlistds', [MemberlistdsController::class, 'index'])->name('memberlistds');
    Route::get('/memberlistds/edit/{id}', [MemberlistdsController::class, 'update']);
    Route::post('/memberlistds/updateuser', [MemberlistdsController::class, 'updateUser']);
    Route::post('/memberlistds/updatepassword', [MemberlistdsController::class, 'updatePassowrd']);
    Route::post('/memberlistds/updateinfomember/{id}', [MemberlistdsController::class, 'updateMember']);

    /*-- Historygameds --*/
    Route::get('/historygameds', [HistorygamedsController::class, 'index']);
    Route::get('/historygameds/detail/{invoice}/{portfolio}', [HistorygamedsController::class, 'detail']);

    /*-- Outstandingds --*/
    Route::get('/outstandingds/{username?}', [OutstandingdsController::class, 'index']);

    /*-- Referralds --*/
    Route::get('/referralds', [ReferraldsController::class, 'index']);

    /*-- Bankds --*/
    Route::get('/bankds', [BankdsController::class, 'index'])->name('bankds');
    Route::post('/storemaster', [BankdsController::class, 'storemaster']);
    Route::post('/storegroupbank', [BankdsController::class, 'storegroupbank']);
    Route::post('/changestatusbank/{jenis?}', [BankdsController::class, 'changeStatusBank']);

    Route::get('/bankds/setbankmaster/{bank}', [BankdsController::class, 'setbankmaster']);
    Route::get('/bankds/addbankmaster', [BankdsController::class, 'addbankmaster']);
    Route::get('/bankds/setgroupbank/{namagroup}', [BankdsController::class, 'setgroupbank']);
    Route::post('/updategroupbank/{namagroup}', [BankdsController::class, 'updategroupbank']);

    Route::get('/bankds/addgroupbank', [BankdsController::class, 'addgroupbank']);
    Route::get('/bankds/setbank', [BankdsController::class, 'setbank']);
    Route::post('/updatesetbank/{bank}', [BankdsController::class, 'updatesetbank']);


    Route::get('/bankds/addbank', [BankdsController::class, 'addbank']);
    Route::post('/storebank', [BankdsController::class, 'storebank']);

    Route::get('/bankds/listmaster', [BankdsController::class, 'listmaster']);

    Route::get('/bankds/listgroup', [BankdsController::class, 'listgroup'])->name('listgroup');
    Route::post('/updatelistgroup/{jenis}', [BankdsController::class, 'updatelistgroup']);
    Route::delete('/deletelistgroup/{id}', [BankdsController::class, 'deletelistgroup'])->name('deletelistgroup');



    Route::get('/bankds/listbank', [BankdsController::class, 'listbank']);

    /*-- Memods --*/
    Route::get('/memods', [MemodsController::class, 'index']);

    /*-- Agentds --*/
    Route::get('/agentds', [AgentdsController::class, 'index']);

    /*-- Eventds --*/
    Route::get('/eventds', [EventdsController::class, 'index']);

    /*-- Apksettingds --*/
    Route::get('/apksettingds', [ApksettingdsController::class, 'index']);

    /*-- Allowedipds --*/
    Route::get('/allowedipds', [AllowedipdsController::class, 'index']);

    /*-- Memotouserds --*/
    Route::get('/memotouserds', [MemotouserdsController::class, 'index']);

    /*-- Usermanagementds --*/
    Route::get('/usermanagementds', [UsermanagementdsController::class, 'index']);

    /*-- MENU 2 --*/
    Route::get('/menu2', [Menu2Controller::class, 'index']);
    Route::get('/menu2/add', [Menu2Controller::class, 'create']);
});
// });
