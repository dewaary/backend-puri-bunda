<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/units/{id}', [UnitController::class, 'show']); 
    Route::put('/units/{id}', [UnitController::class, 'update']);
    Route::delete('/units/{id}', [UnitController::class, 'destroy']);

    Route::put('/positions/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);
    Route::get('/positions/{id}', [PositionController::class, 'show']); 

    Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/units', [UnitController::class, 'index']);
Route::post('/units', [UnitController::class, 'store']);

Route::get('/positions', [PositionController::class, 'index']); // Get all units
Route::post('/positions', [PositionController::class, 'store']); // Create a new unit

Route::get('/employees', [EmployeeController::class, 'index']); // Get all units
Route::post('/employees', [EmployeeController::class, 'store']); // Create a new unit
