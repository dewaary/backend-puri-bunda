<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::with(['unit', 'positions'])->get();
            return ResponseHelper::success('success', 'Employees retrieved successfully', $employees);
        } catch (Exception $e) {
            Log::error('Error retrieving employees: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve employees', 500);
        }
    }

    public function show($id)
    {
        try {
            $employees = Employee::with(['unit', 'positions'])->get();
            if (!$employees) {
                return ResponseHelper::error('error', 'Employee not found', 404);
            }
            return ResponseHelper::success('success', 'Employee retrieved successfully', $employees);
        } catch (Exception $e) {
            Log::error('Error retrieving employee with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to retrieve employee', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|regex:/\d/|unique:employees,username|max:255',
                'password' => 'required|string|min:8',
                'unit_id' => 'required|exists:units,id',
                'position_ids' => 'required|array',
                'position_ids.*' => 'exists:positions,id',
            ]);

            if ($request->has('new_unit')) {
                $unit = Unit::create(['name' => $request->new_unit]);
                $unit_id = $unit->id;
            } else {
                $unit_id = $request->unit_id;
            }

            $employee = Employee::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'unit_id' => $unit_id,
            ]);

            $employee->positions()->attach($request->position_ids);

            return ResponseHelper::success('success', 'Employee created successfully', $employee, 201);

        } catch (ValidationException $e) {
            return ResponseHelper::error('validation_error', $e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to create employee', 500);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return ResponseHelper::error('error', 'Employee not found', 404);
            }
    
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|regex:/\d/|unique:employees,username,' . $id . '|max:255',
                'password' => 'nullable|string|min:6',
                'unit_id' => 'required|exists:units,id',
                'position_id' => 'required|exists:positions,id',
            ]);
    
            $employee->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password ? bcrypt($request->password) : $employee->password,
                'unit_id' => $request->unit_id,
                'position_id' => $request->position_id,
            ]);
    
            return ResponseHelper::success('success', 'Employee updated successfully', $employee);
        } catch (Exception $e) {
            Log::error('Error updating employee with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to update employee', 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return ResponseHelper::error('error', 'Employee not found', 404);
            }

            $employee->delete();
            return ResponseHelper::success('success', 'Employee deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting employee with ID ' . $id . ': ' . $e->getMessage());
            return ResponseHelper::error('error', 'Failed to delete employee', 500);
        }
    }
}