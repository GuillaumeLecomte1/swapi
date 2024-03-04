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
                'created' => $item->created,
                'designation' => $item->designation,
                'edited' => $item->edited,
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
            'created' => $species->created,
            'designation' => $species->designation,
            'edited' => $species->edited,
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
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'une espèce avec succès")
 * )
 */
    public function create(Request $request)
    {
        $species = Species::create($request->all());
    }

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
 *     summary="Modifie une espèce",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Modification d'une espèce avec succès")
 * )
 */
    public function update(Request $request, string $id)
    {
        $species = Species::find($id);
        $species->update($request->all());
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
