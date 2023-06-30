<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TiresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {

    Route::get('/user-info', function (Request $request) {
        return $request->user();
    });

    Route::post('tires',                     [TiresController::class, 'store']);
    Route::post('tires/{id}',                [TiresController::class, 'update']);
    Route::delete('tires/{id}',              [TiresController::class, 'destroy']);
    Route::post('logout',                    [AuthController::class, 'logout']);
});

Route::get('tires',                          [TiresController::class, 'index']);
Route::get('tires/{id}',                     [TiresController::class, 'show']);