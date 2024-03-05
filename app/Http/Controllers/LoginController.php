<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class LoginController extends Controller
{
/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="connecte un utilisateur",
 *     tags={"User"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="mail", type="string", format="email", example="user@example.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="test"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Invalid credentials"),
 *     @OA\Response(response="200", description="Se connecter à l'API")
 * )
 */
    public function login(Request $request)
    {
        // Tentative d'authentification avec JWTAuth
        $credentials = $request->only('mail', 'password');
        if ($token = JWTAuth::attempt($credentials)) {
            // Authentification réussie, retourne le token
            $response = response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $token
            ]);

            $response->cookie('token', $token, 36000);

            return $response;
        }

        // Authentification échouée, retourner une réponse err
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }


/**
 * @OA\Post(
 *     path="/api/logout",
 *     summary="déconnecte un utilisateur",
 *     tags={"User"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Se déconnecter à l'API")
 * )
 */
    public function logout()
    {
        // Invalider le token pour l'utilisateur actuel
        JWTAuth::invalidate(JWTAuth::getToken());

        // Vous pouvez également invalider tous les tokens pour cet utilisateur
        // JWTAuth::invalidate(JWTAuth::getToken(), true);

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ]);
    }


/**
 * @OA\Post(
 *     path="/api/register",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="mail", type="string", format="email", example="user@example.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="test"),
 *             )
 *         )
 *     ),
 *     summary="créer un utilisateur",
 *     tags={"User"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="créer un compte utiliseur à l'API")
 * )
 */
    public function register(Request $request)
    {
        User::create([
            'mail' => $request->mail,
            'password' => Hash::make($request->password),
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }
}