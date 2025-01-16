<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    public function index()
    {
        try {
            $units = Unit::all();
            return ResponseHelper::success('success', 'Units retrieved successfully', $units);
        } catch (Exception $e) {
            Log::error('Error retrieving units: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve units', 500);
        }
    }

    public function show($id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                return ResponseHelper::error('error', 'Unit not found', 404);
            }
            return ResponseHelper::success('success', 'Unit retrieved successfully', $unit);
        } catch (Exception $e) {
            Log::error('Error retrieving unit: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve unit', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);

            $unit = Unit::create(['name' => $request->name]);

            return ResponseHelper::success('success', 'Unit created successfully', $unit, 201);
        } catch (Exception $e) {
            Log::error('Error creating unit: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to create unit', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                return ResponseHelper::error('error', 'Unit not found', 404);
            }

            $request->validate(['name' => 'required|string|max:255']);

            $unit->update(['name' => $request->name]);

            return ResponseHelper::success('success', 'Unit updated successfully', $unit);
        } catch (Exception $e) {
            Log::error('Error updating unit with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to update unit', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                return ResponseHelper::error('error', 'Unit not found', 404);
            }

            $unit->delete();
            return ResponseHelper::success('success', 'Unit deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting unit with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to delete unit', 500);
        }
    }
}
