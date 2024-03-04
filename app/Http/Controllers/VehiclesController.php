<?php

namespace App\Http\Controllers;

use App\Models\Transports;
use Illuminate\Http\Request;
use App\Models\Vehicles;

class VehiclesController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/vehicles",
 *     summary="Afficher la liste des véhicules",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des véhicules")
 * )
 */
    public function readAll()
    {
        $vehicles = Vehicles::with(['films', 'pilots'])->get();

        $transformedData = $vehicles->map(function ($vehicle) {
            $transport = Transports::find($vehicle->id);
            return [
                'name' => $transport->name,
                'model' => $vehicle->vehicle_class,
                'manufacturer' => $transport->manufacturer,
                'cost_in_credits' => $transport->cost_in_credits,
                'length' => $transport->length,
                'max_atmosphering_speed' => $transport->max_atmosphering_speed,
                'crew' => $transport->crew,
                'passengers' => $transport->passengers,
                'cargo_capacity' => $transport->cargo_capacity,
                'consumables' => $transport->consumables,
                'created' => $transport->created,
                'edited' => $transport->edited,
                'films' => $vehicle->films->pluck('url'),
                'pilots' => $vehicle->pilots->pluck('url'),
                'url' =>'http://127.0.0.1:8000/api/vehicles/'. strval($vehicle->id) ,
            ];
        });

        return response()->json(['vehicles' => $transformedData], 200);
    }
    
/**
 * @OA\Get(
 *     path="/api/vehicles/{id}",
 *    @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du Vehicule",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Afficher un véhicule à l'aide de son id",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne le véhicule ciblé par l'id passé en paramètre")
 * )
 */
    public function read(string $id)
    {
        $vehicle = Vehicles::with(['films', 'pilots'])->find($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        $transport = Transports::find($vehicle->id);
        $transformedData = [
            'name' => $transport->name,
                'model' => $vehicle->vehicle_class,
                'manufacturer' => $transport->manufacturer,
                'cost_in_credits' => $transport->cost_in_credits,
                'length' => $transport->length,
                'max_atmosphering_speed' => $transport->max_atmosphering_speed,
                'crew' => $transport->crew,
                'passengers' => $transport->passengers,
                'cargo_capacity' => $transport->cargo_capacity,
                'consumables' => $transport->consumables,
                'created' => $transport->created,
                'edited' => $transport->edited,
                'films' => $vehicle->films->pluck('url'),
                'pilots' => $vehicle->pilots->pluck('url'),
                'url' =>'http://127.0.0.1:8000/api/vehicles/'. strval($vehicle->id) ,
        ];

        return response()->json(['vehicle' => $transformedData], 200);
    }

/**
 * @OA\Post(
 *     path="/api/vehicles",
 *     summary="Créer un véhicule",
 *     tags={"Vehicle"},
 *      @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", format="text", example="Speeder Bike"),
 *                 @OA\Property(property="cargo_capacity", type="integer", format="int32", example=5),
 *                 @OA\Property(property="consumables", type="string", format="text", example="1 day"),
 *                 @OA\Property(property="transport_id", type="integer", format="int32", example=1),
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
 *     @OA\Response(response="200", description="Création d'un véhicule réussie")
 * )
 */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cargo_capacity' => 'required|numeric',
            'consumables' => 'required|string',
            'transport_id' => 'required|exists:transports,id',
        ]);

        $transport = Transports::find($request->input('transport_id'));

        if (!$transport) {
            return response()->json(['message' => 'Transport non trouvé'], 404);
        }

        $vehicle = $transport->vehicles()->create([
            'name' => $request->input('name'),
            'cargo_capacity' => $request->input('cargo_capacity'),
            'consumables' => $request->input('consumables'),
        ]);

        if ($request->has('films')) {
            $vehicle->films()->attach($request->input('films'));
        }

        if ($request->has('people')) {
            $vehicle->people()->attach($request->input('people'));
        }

        return response()->json(['message' => 'Véhicule créé avec succès', 'vehicle' => $vehicle], 201);    
    }

/**
 * @OA\Put(
 *     path="/api/vehicles/{id}",
 *    @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du Vehicule",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Modifier un véhicule à l'aide de son id",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Modification d'un véhicule")
 * )
 */
    public function update(Request $request, string $id)
    {
        $vehicles = Vehicles::find($id);
        $vehicles->update($request->all());
    }

/**
 * @OA\Delete(
 *     path="/api/vehicles/{id}",
 *    @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du Vehicule",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Supprimer un véhicule à l'aide de son id",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Suppression d'un véhicule")
 * )
 */
    public function destroy(string $id)
    {
        $vehicle = Vehicles::find($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicule non trouvé'], 404);
        }

        $vehicle->films()->detach();
        $vehicle->pilots()->detach();

        $vehicle->delete();

        return response()->json(['message' => 'Vehicule supprimé avec succès'], 200);
    }
}
