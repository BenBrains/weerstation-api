<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\SensorController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function () {
    return response()->json(['message' => 'Alive and kicking, welcome to the API!']);
});

Route::get('/health', [HealthController::class, 'status']);

Route::middleware('api_key')->group(function () {
    Route::get('/stations', [StationController::class, 'index']);
    Route::post('/stations', [StationController::class, 'store']);
    Route::get('/stations/{id}', [StationController::class, 'show']);

    Route::get('/sensors', [SensorController::class, 'index']);
    Route::post('/sensors', [SensorController::class, 'store']);
    Route::post('/sensors/data', [SensorController::class, 'storeData']);
    Route::get('/sensors/{id}', [SensorController::class, 'show']);
    Route::get('/sensors/{id}/recent', [SensorController::class, 'recent']);
    Route::get('/sensors/{id}/between', [SensorController::class, 'between']);
});
