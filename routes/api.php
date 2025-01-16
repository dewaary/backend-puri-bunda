<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/units', [UnitController::class, 'index']); // Get all units
Route::get('/units/{id}', [UnitController::class, 'show']); // Get a specific unit
Route::post('/units', [UnitController::class, 'store']); // Create a new unit
Route::put('/units/{id}', [UnitController::class, 'update']); // Update a specific unit
Route::delete('/units/{id}', [UnitController::class, 'destroy']);

Route::get('/positions', [PositionController::class, 'index']); // Get all units
Route::get('/positions/{id}', [PositionController::class, 'show']); // Get a specific unit
Route::post('/positions', [PositionController::class, 'store']); // Create a new unit
Route::put('/positions/{id}', [PositionController::class, 'update']); // Update a specific unit
Route::delete('/positions/{id}', [PositionController::class, 'destroy']);

Route::get('/employees', [EmployeeController::class, 'index']); // Get all units
Route::get('/employees/{id}', [EmployeeController::class, 'show']); // Get a specific unit
Route::post('/employees', [EmployeeController::class, 'store']); // Create a new unit
Route::put('/employees/{id}', [EmployeeController::class, 'update']); // Update a specific unit
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
