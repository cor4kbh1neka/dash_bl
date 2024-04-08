<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiBolaController;
use App\Http\Controllers\DepoWdController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|3
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
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

Route::get('/login/{username}/{iswap}/{ip_log}', [ApiBolaController::class, 'login']);
Route::post('/register', [ApiBolaController::class, 'register']);
Route::get('/get-recommend-matches', [ApiBolaController::class, 'getRecomMatch']);

Route::post('/deposit', [DepoWdController::class, 'deposit']);
Route::post('/withdrawal', [DepoWdController::class, 'withdrawal']);

Route::get('/checkLastTransaction/{jenis}/{username}', [DepoWdController::class, 'getLastStatusTransaction']);
Route::get('/checkBalance/{username}', [DepoWdController::class, 'getBalance']);
