<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LoginHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    
            LoginHistory::create([
                'employee_id' => $employee->id,
                'login_time' => now(),
                'ip_address' => $request->ip(),
            ]);
    
            return ResponseHelper::success('Login successful', 'Successfully logged in', ['token' => $token]);
        } catch (Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());
            return ResponseHelper::error('Failed to login', 'There was an error logging in', 500);
        }
    }

    public function getLoginStats(Request $request)
    {
        try {
            // Mengambil login history per pengguna
            $loginStats = LoginHistory::select('employee_id', DB::raw('COUNT(*) as login_count'))
                ->groupBy('employee_id')
                ->get();
    
            // Ambil data lengkap dari tabel employees untuk setiap user yang memiliki login history
            $userLoginStats = $loginStats->map(function($loginStat) {
                $employee = Employee::find($loginStat->employee_id);
                return [
                    'name' => $employee->name,  // Ambil nama lengkap
                    'username' => $employee->username,  // Ambil username
                    'login_count' => $loginStat->login_count  // Jumlah login
                ];
            });
    
            return ResponseHelper::success('Login stats retrieved', 'Login count per user', ['login_stats' => $userLoginStats]);
        } catch (Exception $e) {
            Log::error('Error retrieving login stats: ' . $e->getMessage());
            return ResponseHelper::error('Failed to retrieve login stats', 'There was an error retrieving login stats', 500);
        }
    }
    

    public function getTopUsers(Request $request)
    {
        try {
            // Ambil login history per pengguna, filter yang login lebih dari 25 kali
            $topUsers = LoginHistory::select('employee_id', DB::raw('COUNT(*) as login_count'))
                ->groupBy('employee_id')
                ->havingRaw('COUNT(*) > 25')  // Hanya ambil yang login lebih dari 25 kali
                ->orderByDesc('login_count')
                ->limit(10)
                ->get();
    
            // Ambil data lengkap dari tabel employees untuk pengguna yang login lebih dari 25 kali
            $topUsersData = $topUsers->map(function($loginStat) {
                $employee = Employee::find($loginStat->employee_id);
                return [
                    'name' => $employee->fullname,  // Nama lengkap
                    'username' => $employee->username,  // Username
                    'login_count' => $loginStat->login_count  // Jumlah login
                ];
            });
    
            return ResponseHelper::success('Top 10 users retrieved', 'Top 10 users by login count', ['top_users' => $topUsersData]);
        } catch (Exception $e) {
            Log::error('Error retrieving top users: ' . $e->getMessage());
            return ResponseHelper::error('Failed to retrieve top users', 'There was an error retrieving top users', 500);
        }
    }
    
}
