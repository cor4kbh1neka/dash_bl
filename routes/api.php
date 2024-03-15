<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiBolaControllers;


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

Route::post('/Bonus', [ApiBolaControllers::class, 'Bonus']);
Route::post('/Cancel', [ApiBolaControllers::class, 'Cancel']);
Route::post('/Deduct', [ApiBolaControllers::class, 'Deduct']);
Route::post('/GetBalance', [ApiBolaControllers::class, 'GetBalance']);
Route::post('/Rollback', [ApiBolaControllers::class, 'Rollback']);
Route::post('/Settle', [ApiBolaControllers::class, 'Settle']);
Route::post('/GetBetStatus', [ApiBolaControllers::class, 'GetBetStatus']);
Route::post('/ReturnStake', [ApiBolaControllers::class, 'ReturnStake']);

Route::get('/login/{username}/{iswap}', [ApiBolaControllers::class, 'login']);
Route::post('/register', [ApiBolaControllers::class, 'register']);
Route::get('/get-recommend-matches', [ApiBolaControllers::class, 'getRecomMatch']);
