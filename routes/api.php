<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('clients')->name('clients.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::post('/', [ClientController::class, 'store']);
    Route::get('/show/{client}', [ClientController::class, 'show']);
    Route::match(['post', 'put', 'patch'], '/{client}', [ClientController::class, 'update']);
    Route::delete('/{client}', [ClientController::class, 'destroy']);
});

Route::prefix('projects')->name('projects.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::get('/show/{project}', [ProjectController::class, 'show']);
    Route::match(['post', 'put', 'patch'], '/{project}', [ProjectController::class, 'update']);
    Route::delete('/{project}', [ProjectController::class, 'destroy']);
});

Route::prefix('timelogs')->name('timelogs.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TimeLogController::class, 'index']);
    Route::post('/manual', [TimeLogController::class, 'manual']);
    Route::post('/start', [TimeLogController::class, 'start']);
    Route::post('/end/{timeLog}', [TimeLogController::class, 'end']);
    Route::delete('/{timeLog}', [TimeLogController::class, 'destroy']);
});
