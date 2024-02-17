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
 *                 @OA\Property(property="mail", type="string", format="email", example="test1@test.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="test"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Se connecter à l'API")
 * )
 */
    public function login(Request $request)
    {
        // $credentials = $request->only('mail', 'password');

        // if ($token = $this->guard()->attempt($credentials)) {
        //     return $this->respondWithToken($token);
        // }

        // return response()->json(['error' => 'Unauthorized'], 401);

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!empty($token)){

            return response()->json([
                "status" => true,
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
    }


/**
 * @OA\Post(
 *     path="/api/logout",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="mail", type="string", format="email", example="test1@test.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="test"),
 *             )
 *         )
 *     ),
 *     summary="déconnecte un utilisateur",
 *     tags={"User"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Se déconnecter à l'API")
 * )
 */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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