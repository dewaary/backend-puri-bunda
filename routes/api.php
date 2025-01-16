<?php

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
