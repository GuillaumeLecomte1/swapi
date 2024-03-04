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
                'created_at' => $item->created_at,
                'update_at' => $item->updated_at,
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
            'created_at' => $people->created_at,
            'updated_at' => $people->updated_at,
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
 *     path="/api/people",
 *     summary="Création d'un personnage",
 *     tags={"People"},
 * @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="birth_year", type="string", format="text", example="19 BBY"),
 *                  @OA\Property(property="eye_color", type="string", format="text", example="Blue"),
 *                  @OA\Property(property="gender", type="string", format="text", example="Male"),
 *                  @OA\Property(property="hair_color", type="string", format="text", example="Blond"),
 *                  @OA\Property(property="height", type="string", format="text", example="172"),
 *                  @OA\Property(property="homeworld", type="string", format="uri", example="1"),
 *                  @OA\Property(property="mass", type="string", format="text", example="77"),
 *                  @OA\Property(property="name", type="string", format="text", example="TEST"),
 *                  @OA\Property(property="skin_color", type="string", format="text", example="Fair"),
 *                  @OA\Property(
 *                      property="species",
 *                      type="array",
 *                      @OA\Items(type="string", format="uri"),
 *                      example={1}
 *                  ),
 *                  @OA\Property(
 *                      property="starships",
 *                      type="array",
 *                      @OA\Items(type="string", format="uri"),
 *                      example={12}
 *                  ),
 *                  @OA\Property(
 *                      property="vehicles",
 *                      type="array",
 *                      @OA\Items(type="string", format="uri"),
 *                      example={14}
 *                  ),
 *                  @OA\Property(
 *                      property="films",
 *                      type="array",
 *                      @OA\Items(type="string", format="uri"),
 *                      example={1,2}
 *                  ),
 *              )
 *          )
 *     ),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'un personnage")
 * )
 */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_year' => 'required|string|max:255',
            'eye_color' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'hair_color' => 'required|string|max:255',
            'height' => 'required|numeric',
            'mass' => 'required|numeric',
            'skin_color' => 'required|string|max:255',
            'homeworld' => 'required|exists:planets,id', 
            'species' => 'array',  
            'starships' => 'array',
            'vehicles' => 'array', 
        ]);

        $people = People::create([
            'name' => $request->input('name'),
            'birth_year' => $request->input('birth_year'),
            'eye_color' => $request->input('eye_color'),
            'gender' => $request->input('gender'),
            'hair_color' => $request->input('hair_color'),
            'height' => $request->input('height'),
            'mass' => $request->input('mass'),
            'skin_color' => $request->input('skin_color'),
            'homeworld' => $request->input('homeworld'),
        ]);

        if ($request->has('species')) {
            $people->species()->attach($request->input('species'));
        }

        if ($request->has('starships')) {
            $people->starships()->attach($request->input('starships'));
        }

        if ($request->has('vehicles')) {
            $people->vehicles()->attach($request->input('vehicles'));
        }

        return response()->json(['message' => 'Personne créée avec succès', 'people' => $people], 201);    }

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
 *     @OA\Response(response="200", description="Modification d'un personnage")
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
 *     @OA\Response(response="200", description="Suppression d'un personnage")
 * )
 */
    public function destroy(string $id)
    {
        $people = People::find($id);

        if (!$people) {
            return response()->json(['message' => 'Personne non trouvée'], 404);
        }

        $people->films()->detach();
        $people->species()->detach();
        $people->starships()->detach();
        $people->vehicles()->detach();

        $people->delete();

        return response()->json(['message' => 'Personne supprimée avec succès'], 200);
    }
}
