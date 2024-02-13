<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;

class VehiclesController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/vehicles",
 *     summary="Get a list of users",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $vehicles = Vehicles::all();
        return response()->json($vehicles);
    }
    
/**
 * @OA\Get(
 *     path="/api/vehicles/{id}",
 *     summary="Get a list of users",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $vehicles = Vehicles::find($id);
        return response()->json($vehicles);
    }

/**
 * @OA\Post(
 *     path="/api/vehicles",
 *     summary="Get a list of users",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function create(Request $request)
    {
        $vehicles = Vehicles::create($request->all());
    }

/**
 * @OA\Put(
 *     path="/api/vehicles/{id}",
 *     summary="Get a list of users",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *     summary="Get a list of users",
 *     tags={"Vehicle"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $vehicles = Vehicles::find($id);
        $vehicles->delete();
    }
}
