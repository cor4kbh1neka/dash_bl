<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiBolaController;
use App\Http\Controllers\ApiController;


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



Route::post('/login', [ApiController::class, 'login']);
Route::get('/historylog/{username}/{ipadress}', [ApiController::class, 'historyLog']);
Route::post('/register/{ipadress}', [ApiController::class, 'register']);
Route::get('/get-recommend-matches', [ApiController::class, 'getRecomMatch']);
Route::get('/cekuserreferral/{username}', [ApiController::class, 'cekuserreferral']);
Route::post('/deposit', [ApiController::class, 'deposit']);
Route::post('/withdrawal', [ApiController::class, 'withdrawal']);
Route::get('/getHistoryDw/{username}', [ApiController::class, 'getHistoryDepoWd']);
Route::get('/checkLastTransaction/{jenis}/{username}', [ApiController::class, 'getLastStatusTransaction']);
Route::get('/checkBalance/{username}', [ApiController::class, 'getBalance']);
Route::get('/getHistoryGame/{username}/{portfolio}/{startDate}/{endDate}', [ApiController::class, 'getHistoryGame']);
Route::get('/getHistoryGameById/{refNos}/{portfolio}', [ApiController::class, 'getHistoryGameById']);
Route::get('/getDataOutstanding', [ApiController::class, 'getDataOutstanding']);


Route::get('/gettransactions', [ApiController::class, 'getTransactions']);
Route::get('/getTransactionsAll', [ApiController::class, 'getTransactionAll']);
Route::get('/getTransactionStatus', [ApiController::class, 'getTransactionStatus']);
Route::get('/getTransactionSaldo', [ApiController::class, 'getTransactionSaldo']);
Route::delete('/deleteTransactions', [ApiController::class, 'deleteTransactions']);


// Route::get('/comparedata', [ApiController::class, 'compareData']);
