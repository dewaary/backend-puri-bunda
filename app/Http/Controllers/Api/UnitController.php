<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return response()->json($units);
    }

    public function show($id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
        return response()->json($unit);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $unit = Unit::create(['name' => $request->name]);

        return response()->json($unit, 201);
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        $request->validate(['name' => 'required|string|max:255']);

        $unit->update(['name' => $request->name]);

        return response()->json($unit);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        $unit->delete();
        return response()->json(['message' => 'Unit deleted successfully']);
    }
}
