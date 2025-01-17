<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/units/show/{id}', [UnitController::class, 'show']); 
    Route::put('/units/update/{id}', [UnitController::class, 'update']);
    Route::delete('/units/delete/{id}', [UnitController::class, 'destroy']);

    Route::put('/positions/update/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/delete/{id}', [PositionController::class, 'destroy']);
    Route::get('/positions/show/{id}', [PositionController::class, 'show']); 

    Route::get('/employees/show/{id}', [EmployeeController::class, 'show']);
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/units', [UnitController::class, 'index']);
Route::post('/units/add-data', [UnitController::class, 'store']);

Route::get('/positions', [PositionController::class, 'index']);
Route::post('/positions/add-data', [PositionController::class, 'store']);

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees/add-data', [EmployeeController::class, 'store']);
