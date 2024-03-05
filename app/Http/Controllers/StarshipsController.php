<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Starships;
use App\Models\Transports;
use Symfony\Component\Mailer\Transport;

class StarshipsController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/starships",
 *     summary="Afficher la liste des vaisseaux spatiaux",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des starships")
 * )
 */
    public function readAll()
    {
        $starships = Starships::with(['films', 'pilots'])->get();

        $transformedData = $starships->map(function ($starship) {
            $transport = Transports::find($starship->id);
            return [
                'name' => $transport->name,
                'model' => $starship->starship_class,
                'manufacturer' => $transport->manufacturer,
                'cost_in_credits' => $transport->cost_in_credits,
                'length' => $transport->length,
                'crew' => $transport->crew,
                'passengers' => $transport->passengers,
                'cargo_capacity' => $transport->cargo_capacity,
                'consumables' => $transport->consumables,
                'hyperdrive_rating' => $starship->hyperdrive_rating,
                'MGLT' => $starship->MGLT,
                'max_atmosphering_speed' => $transport->max_atmosphering_speed,
                'films' => $starship->films->pluck('url'),
                'pilots' => $starship->pilots->pluck('url'),
                'created_at' => $transport->created_at,
                'updated_at' => $transport->updated_at,
                'url' =>env('API_URL') .'starships/'. strval($starship->id) ,
            ];
        });

        return response()->json(['starships' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/starships/{id}",
 *   @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du vaissaux spatial",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher un vaisseau spatial à l'aide de son id",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne un starship")
 * )
 */
    public function read(string $id)
    {
        // $starships = Starships::find($id);
        // $transport = Transports::find($starships["id_transport"]);
        // $starships['transport'] = $transport;
        // return response()->json($starships);
        $starship = Starships::with(['films', 'pilots'])->find($id);

        if (!$starship) {
            return response()->json(['message' => 'Vaisseau spatial non trouvé'], 404);
        }

        $transport = Transports::find($starship->id_transport);
        $transformedData = [
            'name' => $transport->name,
                'model' => $starship->starship_class,
                'manufacturer' => $transport->manufacturer,
                'cost_in_credits' => $transport->cost_in_credits,
                'length' => $transport->length,
                'crew' => $transport->crew,
                'passengers' => $transport->passengers,
                'cargo_capacity' => $transport->cargo_capacity,
                'consumables' => $transport->consumables,
                'hyperdrive_rating' => $starship->hyperdrive_rating,
                'MGLT' => $starship->MGLT,
                'max_atmosphering_speed' => $transport->max_atmosphering_speed,
                'films' => $starship->films->pluck('url'),
                'pilots' => $starship->pilots->pluck('url'),
                'created_at' => $transport->created_at,
                'updated_at' => $transport->updated_at,
                'url' =>env('API_URL') .'starships/'. strval($starship->id) ,
        ];
        return response()->json(['starship' => $transformedData], 200);
        
    }

/**
 * @OA\Post(
 *     path="/api/starships",
 *     summary="Crée un vaisseau spatial",
 *     tags={"Starships"},
 *  @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="model", type="string", format="text", example="TEST"),
 *                 @OA\Property(property="starship_class", type="string", format="text", example="TEST"),
 *                 @OA\Property(property="hyperdrive_rating", type="integer", format="int32", example=2),
 *                 @OA\Property(property="MGLT", type="integer", format="int32", example=2), 
 *                 @OA\Property(property="id_transport", type="integer", format="int32", example=2),
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
 *     @OA\Response(response="200", description="création d'un vaisseau spatial")
 * )
 */
    public function create(Request $request)
    {
        $request->validate([
            'model' => 'required|string|max:255',
            'starship_class' => 'required|string|max:255',
            'hyperdrive_rating' => 'required|numeric',
            'MGLT' => 'required|numeric',
            'id_transport' => 'required|exists:transports,id',
        ]);

        $transport = Transports::find($request->input('id_transport'));

        if (!$transport) {
            return response()->json(['message' => 'Transport non trouvé'], 404);
        }

        $starship = Starships::create([
            'model' => $request->input('model'),
            'starship_class' => $request->input('starship_class'),
            'hyperdrive_rating' => $request->input('hyperdrive_rating'),
            'MGLT' => $request->input('MGLT'),
            'id_transport' => $request->input('id_transport'),
        ]);

        if ($request->has('films')) {
            $starship->films()->attach($request->input('films'));
        }

        return response()->json(['message' => 'Starship créé avec succès', 'starship' => $starship], 201);
    }

/**
 * @OA\Put(
 *     path="/api/starships/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du Vaisseau Spatial",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Death Star"),
 *                 @OA\Property(property="MGLT", type="string", example="10 MGLT"),
 *                 @OA\Property(property="cargo_capacity", type="string", example="1000000000000"),
 *                 @OA\Property(property="consumables", type="string", example="3 years"),
 *                 @OA\Property(property="cost_in_credits", type="string", example="1000000000000"),
 *                 @OA\Property(property="crew", type="string", example="342953"),
 *                 @OA\Property(property="length", type="string", example="120000"),
 *                 @OA\Property(property="manufacturer", type="string", example="Imperial Department of Military Research, Sienar Fleet Systems"),
 *                 @OA\Property(property="max_atmosphering_speed", type="string", example="n/a"),
 *                 @OA\Property(property="model", type="string", example="DS-1 Orbital Battle Station"),
 *                 @OA\Property(property="passengers", type="string", example="843342"),
 *                 @OA\Property(property="starship_class", type="string", example="Deep Space Mobile Battlestation"),
 *             )
 *         )
 *     ),
 *     summary="Modifier un vaisseau spatial",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="modification d'un vaisseau spatial")
 * )
 */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'MGLT' => 'required|string',
            'cargo_capacity' => 'required|string',
            'consumables' => 'required|string',
            'cost_in_credits' => 'required|string',
            'crew' => 'string',
            'length' => 'required|string',
            'manufacturer' => 'required|string',
            'max_atmosphering_speed' => 'required|string',
            'model' => 'required|string',
            'passengers' => 'required|string',
            'starship_class' => 'required|string',
        ]);
    
        $starship = Starships::find($id);
    
        if (!$starship) {
            return response()->json(['message' => 'Starship non trouvé'], 404);
        }
    
        $transport = Transports::find($starship->id_transport);

        if (!$transport) {
            return response()->json(['message' => 'Problème de liaison avec son Transport'], 404);
        }

        $starship->update($request->all());
        $transport->update($request->all());
    
        return response()->json(['message' => 'Starship mis à jour', 'data' => $starship]);
    }

/**
 * @OA\Delete(
 *     path="/api/starships/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du vaisseau spatial",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Supprimer un vaisseau spatial",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Suppression d'un vaisseau spatial")
 * )
 */
    public function destroy(string $id)
    {
        $starship = Starships::find($id);

        if (!$starship) {
            return response()->json(['message' => 'Vaisseau spatial non trouvé'], 404);
        }

        $starship->films()->detach();
        $starship->pilots()->detach();

        $starship->delete();

        return response()->json(['message' => 'Vaisseau spatial supprimé avec succès'], 200);
    }
}
