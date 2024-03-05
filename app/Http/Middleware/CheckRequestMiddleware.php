<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      
        // Vérification pour une réponse 403 Forbidden
        if ($request->header('X-Custom-Header') === 'AnotherValue') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Ajoutez d'autres conditions ici pour d'autres codes d'erreur

        // Exemple pour 404 Not Found
        if ($request->header('X-Specific-Header') === 'SpecificValue') {
            return response()->json(['error' => 'Not Found'], 404);
        }

        // Exemple pour 400 Bad Request

        // Exemple pour 422 Unprocessable Entity
        if ($request->input('email') && !filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Unprocessable Entity'], 422);
        }

        // Exemple pour 500 Internal Server Error
        // Imaginez qu'il y a une vérification qui, si elle échoue, indique un problème plus grave qui ne devrait normalement pas se produire.
        if ($request->header('X-Danger-Header') === 'DangerousValue') {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }

        // Si la condition est remplie, continuez avec la requête
        return $next($request);
    }
}
