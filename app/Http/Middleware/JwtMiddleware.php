<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     public function handle($request, Closure $next)
     {
         $authHeader = $request->header('Authorization');
         if (!$authHeader) {
             return response()->json(['error' => 'Token is required'], 401);
         }
 
         try {
             $user = JWTAuth::parseToken()->authenticate();
 
         } catch (JWTException $e) {
             return response()->json(['error' => 'Token not valid'], 401);
         }
 
         return $next($request);
     }
}
