<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->headers->all());
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // Affichez le message d'erreur pour le débogage
            // dd($e);

            // Vous pouvez également retourner une réponse JSON plus détaillée
            return response()->json(['error' => 'Invalid token', 'message' => $e->getMessage()], 401);
        }

        // Si l'utilisateur n'est pas authentifié, retournez une réponse non autorisée
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Si l'utilisateur est authentifié, continuez le traitement de la requête
        return $next($request);
    }
}
