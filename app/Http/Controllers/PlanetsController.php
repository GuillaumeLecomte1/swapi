<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planets;

class PlanetsController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/planets",
 *     summary="Afficher la listes des planètes",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des planètes")
 * )
 */
    public function readAll()
    {
        $planets = Planets::with(['films','residents'])->get();

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
                'created_at' => $planet->created_at,
                'updated_at' => $planet->updated_at,
                'films' => $planet->films->pluck('url'),
                'residents' => $planet->residents->pluck('url'),
                'url' =>env('API_URL') .'planets/'. strval($planet->id) ,
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
 *       description="ID de la planète",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher une planète à l'aide de son id",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la planète ciblée par l'id passé en paramètre")
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
            'created_at' => $planet->created_at,
            'updated_at' => $planet->updated_at,
            'films' => $planet->films->pluck('url'),
            'url' =>env('API_URL') .'planets/'. strval($planet->id) ,
        ];

        return response()->json(['planet' => $transformedData], 200);
    }

/**
 * @OA\Post(
 *     path="/api/planets",
 *     summary="Crée une planète",
 *     tags={"Planets"},
 * @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", format="text", example="TEST"),
 *                 @OA\Property(property="diameter", type="integer", format="int32", example="10465"),
 *                 @OA\Property(property="rotation_period", type="integer", format="int32", example="23"),
 *                 @OA\Property(property="orbital_period", type="integer", format="int32", example="304"),
 *                 @OA\Property(property="gravity", type="string", format="text", example="1"),
 *                 @OA\Property(property="population", type="integer", format="int32", example="12000"),
 *                 @OA\Property(property="climate", type="string", format="text", example="Afrid"),
 *                 @OA\Property(property="terrain", type="string", format="text", example="Desert"),
 *                 @OA\Property(property="surface_water", type="integer", format="int32", example="1"),
 *                 @OA\Property(
 *                     property="films",
 *                     type="array",
 *                     @OA\Items(type="integer", format="int32"),
 *                     example={1, 2}
 *                 ), 
 *             )
 *         )
 *     ), 
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'une planète")
 * )
 */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'diameter' => 'required|numeric',
            'rotation_period' => 'required|numeric',
            'orbital_period' => 'required|numeric',
            'gravity' => 'required|string|max:255',
            'population' => 'required|numeric',
            'climate' => 'required|string|max:255',
            'terrain' => 'required|string|max:255',
            'surface_water' => 'required|numeric',
            'films' => 'array',      
        ]);

        $planet = Planets::create([
            'name' => $request->input('name'),
            'diameter' => $request->input('diameter'),
            'rotation_period' => $request->input('rotation_period'),
            'orbital_period' => $request->input('orbital_period'),
            'gravity' => $request->input('gravity'),
            'population' => $request->input('population'),
            'climate' => $request->input('climate'),
            'terrain' => $request->input('terrain'),
            'surface_water' => $request->input('surface_water'),
       ]);

        if ($request->has('films')) {
            $planet->films()->attach($request->input('films'));
        }

        return response()->json(['message' => 'Planète créée avec succès', 'planet' => $planet], 201);    }

/**
 * @OA\Put(
 *     path="/api/planets/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID de la planète",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="TEST"),
 *                 @OA\Property(property="diameter", type="string", example="12000"),
 *                 @OA\Property(property="rotation_period", type="string", example="24"),
 *                 @OA\Property(property="orbital_period", type="string", example="365"),
 *                 @OA\Property(property="gravity", type="string", example="1.5"),
 *                 @OA\Property(property="population", type="string", example="500000000"),
 *                 @OA\Property(property="climate", type="string", example="Temperate"),
 *                 @OA\Property(property="terrain", type="string", example="Forest"),
 *                 @OA\Property(property="surface_water", type="string", example="25"),
 *             )
 *         )
 *     ),
 *     summary="Modifie une planète",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Modification d'une planète")
 * )
 */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string',
            'diameter' => 'string',
            'rotation_period' => 'string',
            'orbital_period' => 'string',
            'gravity' => 'string',
            'population' => 'string',
            'climate' => 'string',
            'terrain' => 'string',
            'surface_water' => 'string',
        ]);

        $planet = Planets::find($id);
    
        if (!$planet) {
            return response()->json(['message' => 'Planet non trouvé'], 404);
        }
    
        $planet->update($request->all());
    
        return response()->json(['message' => 'Planet mis à jour', 'data' => $planet]);
    }

/**
 * @OA\Delete(
 *     path="/api/planets/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID de la planète",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Supprimer une planète",
 *     tags={"Planets"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Suppression d'une planète")
 * )
 */
    public function destroy(string $id)
    {
        $planet = Planets::find($id);

        if (!$planet) {
            return response()->json(['message' => 'Planète non trouvée'], 404);
        }

        $planet->delete();

        return response()->json(['message' => 'Planète supprimée avec succès'], 200);
    }
}
