<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function index()
    {
        try {
            $positions = Position::all();
            return ResponseHelper::success('success', 'Positions retrieved successfully', $positions);
        } catch (Exception $e) {
            Log::error('Error retrieving positions: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve positions', 500);
        }
    }

    public function show($id)
    {
        try {
            $position = Position::find($id);
            if (!$position) {
                return ResponseHelper::error('error', 'Position not found', 404);
            }
            return ResponseHelper::success('success', 'Position retrieved successfully', $position);
        } catch (Exception $e) {
            Log::error('Error retrieving position: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve position', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);

            $position = Position::create(['name' => $request->name]);

            return ResponseHelper::success('success', 'Position created successfully', $position, 201);
        } catch (Exception $e) {
            Log::error('Error creating position: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to create position', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $position = Position::find($id);
            if (!$position) {
                return ResponseHelper::error('error', 'Position not found', 404);
            }

            $request->validate(['name' => 'required|string|max:255']);

            $position->update(['name' => $request->name]);

            return ResponseHelper::success('success', 'Position updated successfully', $position);
        } catch (Exception $e) {
            Log::error('Error updating position with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to update position', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $position = Position::find($id);
            if (!$position) {
                return ResponseHelper::error('error', 'Position not found', 404);
            }

            $position->delete();
            return ResponseHelper::success('success', 'Position deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting position with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to delete position', 500);
        }
    }
}
