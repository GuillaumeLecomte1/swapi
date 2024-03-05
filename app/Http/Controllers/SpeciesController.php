<?php

namespace App\Http\Controllers;

use App\Models\Films;
use App\Models\People;
use App\Models\Planets;
use Illuminate\Http\Request;
use App\Models\Species;
use Illuminate\Support\Facades\DB;

class SpeciesController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/species",
 *     summary="Afficher la liste des espèces",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des species")
 * )
 */
    public function readAll()
    {
        $species = Species::with(['people', 'films', 'homeworld'])->get();
        $transformedData = $species->map(function ($item) {
            return [
                'name' => $item->name,
                'average_height' => $item->average_height,
                'average_lifespan' => $item->average_lifespan,
                'classification' => $item->classification,
                'created_at' => $item->created_at,
                'designation' => $item->designation,
                'updated_at' => $item->updated_at,
                'eye_colors' => $item->eye_colors,
                'hair_colors' => $item->hair_colors,
                'homeworld' =>'http://127.0.0.1:8000/api/planets/'. strval($item->homeworld),
                'language' => $item->language,
                'people' => $item->people->pluck('url'),
                'films' => $item->films->pluck('url'),
                'skin_colors' => $item->skin_colors,
                'url' =>'http://127.0.0.1:8000/api/species/'. strval($item->id) ,
            ];
        });

        return response()->json(['species' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/species/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID de l'Espcèce",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher une espèce à l'aide de son id",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Afficher une espèce à l'aide de son id")
 * )
 */
    public function read(string $id)
    {
        $species = Species::with(['people', 'films', 'homeworld'])->find($id);

        if (!$species) {
            return response()->json(['error' => 'Species non trouvé'], 404);
        }

        $transformedData = [
            'name' => $species->name,
            'average_height' => $species->average_height,
            'average_lifespan' => $species->average_lifespan,
            'classification' => $species->classification,
            'created_at' => $species->created_at,
            'designation' => $species->designation,
            'updated_at' => $species->updated_at,
            'eye_colors' => $species->eye_colors,
            'hair_colors' => $species->hair_colors,
            'homeworld' => 'http://127.0.0.1:8000/api/planets/' . strval($species->homeworld),
            'language' => $species->language,
            'people' => $species->people->pluck('url'),
            'films' => $species->films->pluck('url'),
            'skin_colors' => $species->skin_colors,
            'url' => 'http://127.0.0.1:8000/api/species/' . strval($species->id),
        ];

        return response()->json(['species' => $transformedData], 200);
    }

/**
 * @OA\Post(
 *     path="/api/species",
 *     summary="Crée une espèce",
 *     tags={"Species"},
 * @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", format="text", example="TEST"),
 *                 @OA\Property(property="average_height", type="integer", format="int32", example="2.1"),
 *                 @OA\Property(property="average_lifespan", type="integer", format="int32", example="400"),
 *                 @OA\Property(property="classification", type="string", format="text", example="Mammal"),
 *                 @OA\Property(property="designation", type="string", format="text", example="Sentient"),
 *                 @OA\Property(property="eye_colors", type="string", format="text", example="Blue, Brown"),
 *                 @OA\Property(property="hair_colors", type="string", format="text", example="Brown, Black"),
 *                 @OA\Property(property="homeworld", type="integer", format="int32", example="1"),
 *                 @OA\Property(property="language", type="string", format="text", example="Shyriiwook"),
 *                 @OA\Property(property="skin_colors", type="string", format="text", example="gray"),
 *                 @OA\Property(
 *                     property="films",
 *                     type="array",
 *                     @OA\Items(type="integer", format="int32"),
 *                     example={1, 2}
 *                 ),
 *                 @OA\Property(
 *                     property="people",
 *                     type="array",
 *                     @OA\Items(type="integer", format="int32"),
 *                     example={1, 2}
 *                 ), 
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'une espèce avec succès")
 * )
 */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'average_height' => 'required|numeric',
            'average_lifespan' => 'required|numeric',
            'classification' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'eye_colors' => 'string|max:255',
            'hair_colors' => 'string|max:255',
            'homeworld' => 'required|exists:planets,id', 
            'language' => 'string|max:255',
            'skin_colors' => 'string|max:255',
            'people' => 'array', 
            'films' => 'array',  
        ]);

        $species = Species::create([
            'name' => $request->input('name'),
            'average_height' => $request->input('average_height'),
            'average_lifespan' => $request->input('average_lifespan'),
            'classification' => $request->input('classification'),
            'designation' => $request->input('designation'),
            'eye_colors' => $request->input('eye_colors'),
            'hair_colors' => $request->input('hair_colors'),
            'homeworld' => $request->input('homeworld'),
            'language' => $request->input('language'),
            'skin_colors' => $request->input('skin_colors'),
        ]);

        if ($request->has('people')) {
            $species->people()->attach($request->input('people'));
        }

        if ($request->has('films')) {
            $species->films()->attach($request->input('films'));
        }

        return response()->json(['message' => 'Espèce créée avec succès', 'species' => $species], 201);    }

/**
 * @OA\Put(
 *     path="/api/species/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID de l'espèce",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Wookie"),
 *                 @OA\Property(property="average_height", type="string", example="2.1"),
 *                 @OA\Property(property="average_lifespan", type="string", example="400"),
 *                 @OA\Property(property="classification", type="string", example="Mammal"),
 *                 @OA\Property(property="designation", type="string", example="Sentient"),
 *                 @OA\Property(property="eye_colors", type="string", example="blue, green, yellow, brown, golden, red"),
 *                 @OA\Property(property="hair_colors", type="string", example="black, brown"),
 *                 @OA\Property(property="homeworld", type="string", example="1"),
 *                 @OA\Property(property="language", type="string", example="Shyriiwook"),
 *                 @OA\Property(property="skin_colors", type="string", example="gray"),
 *             )
 *         )
 *     ),
 *     summary="Modifie une espèce",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Modification d'une espèce avec succès")
 * )
 */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'average_height' => 'required|string',
            'average_lifespan' => 'required|string',
            'classification' => 'required|string',
            'designation' => 'required|string',
            'eye_colors' => 'required|string',
            'hair_colors' => 'required|string',
            'homeworld' => 'required|string',
            'language' => 'required|string',
            'skin_colors' => 'required|string',
        ]);
    
        $species = Species::find($id);
    
        if (!$species) {
            return response()->json(['message' => 'Species non trouvé'], 404);
        }
    
        $species->update($request->all());
    
        return response()->json(['message' => 'Species mis a jour', 'data' => $species]);
    }

/**
 * @OA\Delete(
 *     path="/api/species/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID de l'espèce",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Supprimer une espèce",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Suppression d'une espèce avec succès")
 * )
 */
    public function destroy(string $id)
    {
        $species = Species::find($id);

        if (!$species) {
            return response()->json(['message' => 'Espèce non trouvée'], 404);
        }

        $species->films()->detach();
        $species->people()->detach();

        $species->delete();

        return response()->json(['message' => 'Espèce supprimée avec succès'], 200);
    }
}
