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
 *     summary="Get a list of users",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $starships = Starships::all();
        foreach($starships as $starship){
            $transport = Transports::find($starship["id_transport"]);
            $starship['transport'] = $transport;
        }
        return response()->json($starships);
    }
    
/**
 * @OA\Get(
 *     path="/api/starships/{id}",
 *   @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Get a list of users",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $starships = Starships::find($id);
        $transport = Transports::find($starships["id_transport"]);
        $starships['transport'] = $transport;
        return response()->json($starships);
    }

/**
 * @OA\Post(
 *     path="/api/starships",
 *     summary="Get a list of users",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *     summary="Get a list of users",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Get a list of users",
 *     tags={"Starships"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $starships = Starships::find($id);
        $starships->delete();
    }
}
