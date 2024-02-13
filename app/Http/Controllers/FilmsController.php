<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Films;

class FilmsController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/films",
 *     summary="Get a list of users",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $films = Films::all();
        return response()->json($films);
    }
    
/**
 * @OA\Get(
 *     path="/api/films/:id",
 *     summary="Get a list of users",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $films = Films::find($id);
        return response()->json($films);
    }

/**
 * @OA\Post(
 *     path="/api/films",
 *     summary="Get a list of users",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function create(Request $request)
    {
        $films = Films::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $films = Films::find($id);
        $films->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $films = Films::find($id);
        $films->delete();
    }
}
