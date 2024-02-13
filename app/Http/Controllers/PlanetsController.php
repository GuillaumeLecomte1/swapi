<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planets;

class PlanetsController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/planets",
 *     summary="Get a list of users",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $planet = Planets::all();
        return response()->json($planet);
    }
    
/**
 * @OA\Get(
 *     path="/api/planets/:id",
 *     summary="Get a list of users",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $planet = Planets::find($id);
        return response()->json($planet);
    }

/**
 * @OA\Post(
 *     path="/api/planets",
 *     summary="Get a list of users",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function create(Request $request)
    {
        $planet = Planets::create($request->all());
    }

/**
 * @OA\Put(
 *     path="/api/planets/:id",
 *     summary="Get a list of users",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function update(Request $request, string $id)
    {
        $planet = Planets::find($id);
        $planet->update($request->all());
    }

/**
 * @OA\Delete(
 *     path="/api/planets/:id",
 *     summary="Get a list of users",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $planet = Planets::find($id);
        $planet->delete();
    }
}
