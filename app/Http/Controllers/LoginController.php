<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
/**
 * @OA\Post(
 *     path="/login",
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
        $credentials = $request->only('mail', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // return redirect('/api/documentation');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


/**
 * @OA\Post(
 *     path="/logout",
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return view('welcome');
    }


/**
 * @OA\Post(
 *     path="/register",
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
        $user = User::create([
            'mail' => $request->mail,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
    }
}
