<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiBolaController;
use App\Http\Controllers\BankdsController;
use App\Http\Controllers\DepoWdController;
use App\Http\Controllers\Menu2Controller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|3
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!s
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/Bonus', [ApiBolaController::class, 'Bonus']);
Route::post('/Cancel', [ApiBolaController::class, 'Cancel']);
Route::post('/Deduct', [ApiBolaController::class, 'Deduct']);
Route::post('/GetBalance', [ApiBolaController::class, 'GetBalance']);
Route::post('/Rollback', [ApiBolaController::class, 'Rollback']);
Route::post('/Settle', [ApiBolaController::class, 'Settle']);
Route::post('/GetBetStatus', [ApiBolaController::class, 'GetBetStatus']);
Route::post('/ReturnStake', [ApiBolaController::class, 'ReturnStake']);
Route::delete('/deleteTransactions', [ApiBolaController::class, 'deleteTransactions']);

Route::get('/gettransactions', [ApiBolaController::class, 'getTransactions']);




Route::get('/login/{username}/{iswap}/{device}', [ApiBolaController::class, 'login']);
Route::get('/historylog/{username}/{ipadress}', [ApiBolaController::class, 'historyLog']);

Route::post('/register/{ipadress}', [ApiBolaController::class, 'register']);

Route::get('/get-recommend-matches', [ApiBolaController::class, 'getRecomMatch']);

Route::post('/deposit', [DepoWdController::class, 'deposit']);
Route::post('/withdrawal', [DepoWdController::class, 'withdrawal']);
Route::get('/getHistoryDw/{username}', [DepoWdController::class, 'getHistoryDepoWd']);

Route::get('/checkLastTransaction/{jenis}/{username}', [DepoWdController::class, 'getLastStatusTransaction']);
Route::get('/checkBalance/{username}', [DepoWdController::class, 'getBalance']);



Route::get('/getTransactions', [DepoWdController::class, 'getTransactions']);
Route::get('/getTransactionStatus', [DepoWdController::class, 'getTransactionStatus']);
Route::get('/getTransactionSaldo', [DepoWdController::class, 'getTransactionSaldo']);


Route::get('/getDataOutstanding', [Menu2Controller::class, 'getDataOutstanding']);



Route::get('/comparedata', [BankdsController::class, 'compareData']);
