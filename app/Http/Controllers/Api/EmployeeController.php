<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['unit', 'position'])->get();
        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employee::with(['unit', 'position'])->find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:employees,username|max:255',
            'password' => 'required|string|min:6',
            'unit_id' => 'required|exists:units,id',
            'position_id' => 'required|exists:positions,id',
            'joined_at' => 'required|date',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'unit_id' => $request->unit_id,
            'position_id' => $request->position_id,
            'joined_at' => $request->joined_at,
        ]);

        return response()->json($employee, 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:employees,username,' . $id . '|max:255',
            'password' => 'nullable|string|min:6',
            'unit_id' => 'required|exists:units,id',
            'position_id' => 'required|exists:positions,id',
            'joined_at' => 'required|date',
        ]);

        $employee->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $employee->password,
            'unit_id' => $request->unit_id,
            'position_id' => $request->position_id,
            'joined_at' => $request->joined_at,
        ]);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
