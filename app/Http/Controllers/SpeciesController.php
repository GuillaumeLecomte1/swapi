<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;

class SpeciesController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/species",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $species = Species::all();
        return response()->json($species);
    }
    
/**
 * @OA\Get(
 *     path="/api/species/:id",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $species = Species::find($id);
        return response()->json($species);
    }

/**
 * @OA\Post(
 *     path="/api/species",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function create(Request $request)
    {
        $species = Species::create($request->all());
    }

/**
 * @OA\Put(
 *     path="/api/species/:id",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function update(Request $request, string $id)
    {
        $species = Species::find($id);
        $species->update($request->all());
    }

/**
 * @OA\Delete(
 *     path="/api/species/:id",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $species = Species::find($id);
        $species->delete();
    }
}
