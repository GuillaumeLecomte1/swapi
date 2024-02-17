<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJwtToken
{
    public function handle($request, Closure $next)
    {
          try {
               $user = JWTAuth::parseToken()->authenticate();
          } catch (Exception $e) {
               return response()->json(['error' => 'Invalid token'], 401);
          }

          return $next($request);
    }
}


?>