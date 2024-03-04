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
                'created' => $transport->created,
                'edited' => $transport->edited,
                'url' =>'http://127.0.0.1:8000/api/starships/'. strval($starship->id) ,
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

        $transport = Transports::find($starship->id);
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
                'created' => $transport->created,
                'edited' => $transport->edited,
                'url' =>'http://127.0.0.1:8000/api/starships/'. strval($starship->id) ,
        ];
        return response()->json(['starship' => $transformedData], 200);
        
    }

/**
 * @OA\Post(
 *     path="/api/starships",
 *     summary="Crée un vaisseau spatial",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="création d'un vaisseau spatial")
 * )
 */
    public function create(Request $request)
    {
        $starships = Starships::create($request->all());
    }

/**
 * @OA\Put(
 *     path="/api/starships/{id}",
 * @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Modifier un vaisseau spatial",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="modification d'un vaisseau spatial")
 * )
 */
    public function update(Request $request, string $id)
    {
        $starships = Starships::find($id);
        $starships->update($request->all());
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
        $starships = Starships::find($id);
        $starships->delete();
    }
}
