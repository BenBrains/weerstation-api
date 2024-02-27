<?php

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
    return response()->json(['message' => 'Alive and kicking']);
});

Route::post('/insert', function (Request $request) {
    $body = $request->getContent();
    return response()->json(['message' => 'Data received', 'data' => $body]);
});

Route::get('/stations', [StationController::class, 'index']);
Route::get('/stations/{id}', [StationController::class, 'show']);

Route::get('/sensors', [SensorController::class, 'index']);
Route::get('/sensors/{id}', [SensorController::class, 'show']);
Route::get('/sensors/{id}/recent', [SensorController::class, 'recent']);
Route::get('/sensors/{id}/between', [SensorController::class, 'between']);
