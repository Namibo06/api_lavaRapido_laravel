<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $message='';

        try {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            $message='Token expirado';
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $message='Token Inválido';
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $message='Fornecer token';
        }
        return response()->json([
            'success'=>true,
            'message'=>$message
        ]);
    }
}
