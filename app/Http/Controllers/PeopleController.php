<?php
namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/people",
 *     summary="Afficher la liste des personnages",
 *     tags={"People"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des personnages")
 * )
 */
    public function readAll()
    {
        $people = People::with(['films', 'species', 'starships', 'vehicles'])->get();
        $transformedData = $people->map(function ($item) {
            return [
                'name' => $item->name,
                'birth_year' => $item->birth_year,
                'eye_color' => $item->eye_color,
                'gender' => $item->gender,
                'hair_color' => $item->hair_color,
                'height' => $item->height,
                'homeworld' => 'http://127.0.0.1:8000/api/planets/'. strval($item->homeworld),
                'mass' => $item->mass,
                'skin_color' => $item->skin_color,
                'created' => $item->created,
                'edited' => $item->edited,
                'films' => $item->films->pluck('url'),
                'species' => $item->species->pluck('url'),
                'starships' => $item->starships->pluck('url'),
                'vehicles' => $item->vehicles->pluck('url'),
                'url' => 'http://127.0.0.1:8000/api/people/'. strval($item->id),
            ];
        });

        return response()->json(['people' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/people/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du personnage",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher un personnage à l'aide de son id",
 *     tags={"People"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne le personnage ciblé par l'id passé en paramètre")
 * )
 */
    public function read(string $id)
    {
        $people = People::with(['films', 'species', 'starships', 'vehicles'])->get()->find($id);

        if (!$people) {
            return response()->json(['message' => 'Personne non trouvée'], 404);
        }

        $transformedData = [
            'name' => $people->name,
            'birth_year' => $people->birth_year,
            'eye_color' => $people->eye_color,
            'gender' => $people->gender,
            'hair_color' => $people->hair_color,
            'height' => $people->height,
            'homeworld' => 'http://127.0.0.1:8000/api/planets/'. strval($people->homeworld),
            'mass' => $people->mass,
            'skin_color' => $people->skin_color,
            'created' => $people->created,
            'edited' => $people->edited,
            'films' => $people->films->pluck('url'),
            'species' => $people->species->pluck('url'),
            'starships' => $people->starships->pluck('url'),
            'vehicles' => $people->vehicles->pluck('url'),
            'url' => 'http://127.0.0.1:8000/api/people/'. strval($people->id),
        ];

        return response()->json(['people' => $transformedData], 200);
    }

/**
 * @OA\Post(
 *     path="/api/people/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du personnage",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Création d'un personnage",
 *     tags={"People"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function create(Request $request)
    {
        $people = People::create($request->all());
    }

/**
 * @OA\Put(
 *     path="/api/people/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du personnage",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Modifier un personnage",
 *     tags={"People"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function update(Request $request, string $id)
    {
        $people = People::find($id);
        $people->update($request->all());
    }

/**
 * @OA\Delete(
 *     path="/api/people/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du personnage",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Suppression d'un personnage",
 *     tags={"People"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $people = People::find($id);
        $people->delete();
    }
}
