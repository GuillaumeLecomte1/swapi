<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Films;

class FilmsController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/films",
 *     summary="Afficher la liste des films",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $films = Films::with(['characters', 'planets', 'species', 'starships', 'vehicles'])->get();

        $transformedData = $films->map(function ($film) {
            return [
                'title' => $film->title,
                'episode_id' => $film->episode_id,
                'opening_crawl' => $film->opening_crawl,
                'director' => $film->director,
                'producer' => $film->producer,
                'release_date' => $film->release_date,
                'created_at' => $film->created_at,
                'updated_at' => $film->updated_at,
                'characters' => $film->characters->pluck('url'),
                'planets' => $film->planets->pluck('url'),
                'species' => $film->species->pluck('url'),
                'starships' => $film->starships->pluck('url'),
                'vehicles' => $film->vehicles->pluck('url'),
                'url' => 'http://127.0.0.1:8000/api/films/' . strval($film->id),
            ];
        });

        return response()->json(['films' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/films/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="Afficher un film à l'aide de son id",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher un film à l'aide de son id",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne le film ciblé par l'id passé en paramètre")
 * )
 */
    public function read(string $id)
    {
        $film = Films::with(['characters', 'planets', 'species', 'starships', 'vehicles'])->find($id);

        if (!$film) {
            return response()->json(['message' => 'Film non trouvé'], 404);
        }

        $transformedData = [
            'title' => $film->title,
            'episode_id' => $film->episode_id,
            'opening_crawl' => $film->opening_crawl,
            'director' => $film->director,
            'producer' => $film->producer,
            'release_date' => $film->release_date,
            'created_at' => $film->created_at,
            'updated_at' => $film->updated_at,
            'characters' => $film->characters->pluck('url'),
            'planets' => $film->planets->pluck('url'),
            'species' => $film->species->pluck('url'),
            'starships' => $film->starships->pluck('url'),
            'vehicles' => $film->vehicles->pluck('url'),
            'url' => 'http://127.0.0.1:8000/api/films/' . strval($film->id),
        ];

        return response()->json(['film' => $transformedData], 200);
    }

/**
 * @OA\Post(
 *     path="/api/films",
 *     summary="Créé un film",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'un film")
 * )
 */
    public function create(Request $request)
    {
        $films = Films::create($request->all());
    }

    if ($request->has('characters')) {
        $film->characters()->attach($request->input('characters'));
    }

    if ($request->has('starships')) {
        $film->starships()->attach($request->input('starships'));
    }

    if ($request->has('vehicles')) {
        $film->vehicles()->attach($request->input('vehicles'));
    }

    if ($request->has('species')) {
        $film->species()->attach($request->input('species'));
    }

    return response()->json([
        'message' => 'Film créée avec succès',
        'film' => $film,
    ], 201);   
}


/**
 * @OA\Put(
 *     path="/api/films/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Modifier un film",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Modification d'un film")
 * )
 */
    public function update(Request $request, string $id)
    {
        $films = Films::find($id);
        $films->update($request->all());
    }

/**
 * @OA\Delete(
 *     path="/api/films/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Supprimer un film",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Suppression d'un film")
 * )
 */
    public function destroy(string $id)
    {
        $film = Films::find($id);

        if (!$film) {
            return response()->json(['message' => 'Film non trouvé'], 404);
        }

        $film->planets()->detach();
        $film->species()->detach();
        $film->starships()->detach();
        $film->vehicles()->detach();

        $film->delete();

        return response()->json(['message' => 'Film supprimé avec succès'], 200);
    }
}
