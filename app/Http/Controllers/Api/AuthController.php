<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::error('Validation failed', $validator->errors(), 400);
            }

            $employee = Employee::where('username', $request->username)->first();

            if (!$employee || !Hash::check($request->password, $employee->password)) {
                return ResponseHelper::error('Invalid credentials', 'The provided credentials are incorrect', 401);
            }

            $token = JWTAuth::fromUser($employee);

            return ResponseHelper::success('Login successful', 'Successfully logged in', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());
            return ResponseHelper::error('Failed to login', 'There was an error logging in', 500);
        }
    }
}
