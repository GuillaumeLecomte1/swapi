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
        $planets = Planets::with(['films'])->get();

        $transformedData = $planets->map(function ($planet) {
            return [
                'name' => $planet->name,
                'climate' => $planet->climate,
                'terrain' => $planet->terrain,
                'diameter' => $planet->diameter,
                'gravity' => $planet->gravity,
                'orbital_period' => $planet->orbital_period,
                'rotation_period' => $planet->rotation_period,
                'surface_water' => $planet->surface_water,
                'population' => $planet->population,
                'created' => $planet->created,
                'edited' => $planet->edited,
                'films' => $planet->films->pluck('url'),
                'url' =>'http://127.0.0.1:8000/api/planets/'. strval($planet->id) ,
            ];
        });

        return response()->json(['planets' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/planets/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Get a list of users",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $planet = Planets::with(['films'])->find($id);

        if (!$planet) {
            return response()->json(['message' => 'Planète non trouvée'], 404);
        }

        $transformedData = [
            'name' => $planet->name,
            'climate' => $planet->climate,
            'terrain' => $planet->terrain,
            'diameter' => $planet->diameter,
            'gravity' => $planet->gravity,
            'orbital_period' => $planet->orbital_period,
            'rotation_period' => $planet->rotation_period,
            'surface_water' => $planet->surface_water,
            'population' => $planet->population,
            'created' => $planet->created,
            'edited' => $planet->edited,
            'films' => $planet->films->pluck('url'),
            'url' =>'http://127.0.0.1:8000/api/planets/'. strval($planet->id) ,
        ];

        return response()->json(['planet' => $transformedData], 200);
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
 *     path="/api/planets/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
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
 *     path="/api/planets/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
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
