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
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string", example="A New Hope"),
 *                 @OA\Property(property="episode_id", type="integer", example=4),
 *                 @OA\Property(property="opening_crawl", type="string", example="It is a period of civil war..."),
 *                 @OA\Property(property="director", type="string", example="George Lucas"),
 *                 @OA\Property(property="producer", type="string", example="Gary Kurtz, Rick McCallum"),
 *                 @OA\Property(property="release_date", type="string", format="date", example="1977-05-25"),
 *                 @OA\Property(
 *                     property="planets",
 *                     type="array",
 *                     @OA\Items(type="string", format="uri"),
 *                     example={1}
 *                 ),
 *                 @OA\Property(
 *                     property="characters",
 *                     type="array",
 *                     @OA\Items(type="string", format="uri"),
 *                     example={1}
 *                 ),
 *                 @OA\Property(
 *                     property="starships",
 *                     type="array",
 *                     @OA\Items(type="string", format="uri"),
 *                     example={2}
 *                 ),
 *                 @OA\Property(
 *                     property="vehicles",
 *                     type="array",
 *                     @OA\Items(type="string", format="uri"),
 *                     example={4}
 *                 ),
 *                 @OA\Property(
 *                     property="species",
 *                     type="array",
 *                     @OA\Items(type="string", format="uri"),
 *                     example={1}
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Création d'un film")
 * )
 */
public function create(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'episode_id' => 'required|integer',
        'opening_crawl' => 'required|string',
        'director' => 'required|string|max:255',
        'producer' => 'required|string|max:255',
        'release_date' => 'required|date',
        'planets' => 'array',      
        'characters' => 'array',   
        'starships' => 'array',    
        'vehicles' => 'array',     
        'species' => 'array',      
    ]);

    $film = Films::create([
        'title' => $request->input('title'),
        'episode_id' => $request->input('episode_id'),
        'opening_crawl' => $request->input('opening_crawl'),
        'director' => $request->input('director'),
        'producer' => $request->input('producer'),
        'release_date' => $request->input('release_date'),
    ]);

    if ($request->has('planets')) {
        $film->planets()->attach($request->input('planets'));
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
        'message' => 'Film created successfully',
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
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string", example="A New Hope"),
 *                 @OA\Property(property="episode_id", type="integer", example=4),
 *                 @OA\Property(property="opening_crawl", type="string", example="It is a period of civil war..."),
 *                 @OA\Property(property="director", type="string", example="George Lucas"),
 *                 @OA\Property(property="producer", type="string", example="Gary Kurtz, Rick McCallum"),
 *                 @OA\Property(property="release_date", type="string", format="date", example="1977-05-25"),
 *                 @OA\Property(
 *                     property="planets",
 *                     type="array",
 *                     @OA\Items(type="string", format="text"),
 *                     example={1}
 *                 ),
 *                 @OA\Property(
 *                     property="characters",
 *                     type="array",
 *                     @OA\Items(type="string", format="text"),
 *                     example={1}
 *                 ),
 *                 @OA\Property(
 *                     property="starships",
 *                     type="array",
 *                     @OA\Items(type="string", format="text"),
 *                     example={2}
 *                 ),
 *                 @OA\Property(
 *                     property="vehicles",
 *                     type="array",
 *                     @OA\Items(type="string", format="text"),
 *                     example={4}
 *                 ),
 *                 @OA\Property(
 *                     property="species",
 *                     type="array",
 *                     @OA\Items(type="string", format="text"),
 *                     example={1}
 *                 ),
 *             )
 *         )
 *     ),
 *     summary="Modifier un film",
 *     tags={"Films"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'episode_id' => 'required|integer',
            'opening_crawl' => 'required|string',
            'director' => 'required|string|max:255',
            'producer' => 'required|string|max:255',
            'release_date' => 'required|date',
            'planets' => 'array',      
            'characters' => 'array',   
            'starships' => 'array',    
            'vehicles' => 'array',     
            'species' => 'array',      
        ]);
    
        $film = Films::findOrFail($id);
    
        $film->update([
            'title' => $request->input('title'),
            'episode_id' => $request->input('episode_id'),
            'opening_crawl' => $request->input('opening_crawl'),
            'director' => $request->input('director'),
            'producer' => $request->input('producer'),
            'release_date' => $request->input('release_date'),
        ]);
    
        if ($request->has('planets')) {
            $film->planets()->sync($request->input('planets'));
        }
    
        if ($request->has('characters')) {
            $film->characters()->sync($request->input('characters'));
        }
    
        if ($request->has('starships')) {
            $film->starships()->sync($request->input('starships'));
        }
    
        if ($request->has('vehicles')) {
            $film->vehicles()->sync($request->input('vehicles'));
        }
    
        if ($request->has('species')) {
            $film->species()->sync($request->input('species'));
        }
    
        return response()->json([
            'message' => 'Film mis à jour',
            'film' => $film,
        ], 200);
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
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
