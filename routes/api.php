<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutPlantController;
use App\Http\Controllers\ForestController;
use App\Http\Controllers\HammeredPlantsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// queste vanno inserite nel middlware auth:sancutm
Route::apiResource('plants', PlantController::class);
Route::apiResource('hammered-plants', HammeredPlantsController::class);
Route::apiResource('cut-plants', CutPlantController::class);
Route::apiResource('forests', ForestController::class);
Route::apiResource('lots', LotController::class);
Route::apiResource('logs', LogController::class);
Route::get('cutting-lots', [LotController::class, 'getCuttingFilteredList']);
Route::get('cutted-lots', [LotController::class, 'getCuttedFilteredList']);
Route::get('getPlantByForestId', [PlantController::class, 'getPlantByForestId']);
