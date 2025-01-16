<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        return response()->json($positions);
    }

    public function show($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }
        return response()->json($position);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $position = Position::create(['name' => $request->name]);

        return response()->json($position, 201);
    }

    public function update(Request $request, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        $request->validate(['name' => 'required|string|max:255']);

        $position->update(['name' => $request->name]);

        return response()->json($position);
    }

    public function destroy($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        $position->delete();
        return response()->json(['message' => 'Position deleted successfully']);
    }
}
