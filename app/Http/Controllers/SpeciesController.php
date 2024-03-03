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
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function readAll()
    {
        $species = Species::all();
        foreach($species as $specie){
            $homeworld = Planets::find($specie['homeworld']);
            $people_specie = DB::table('people_species')->where('species_id',$specie['id'])->get();
            $films_specie = DB::table('film_species')->where('films_id',$specie['id'])->get();

            $list_people = array();
            foreach($people_specie as $p_s){
                array_push($list_people,People::find($p_s->people_id));
                //$list_people[] = People::find($p_s->people_id);
            }

            $list_films = array();
            foreach($people_specie as $p_s){
                array_push($list_people,People::find($p_s->people_id));
                //$list_people[] = People::find($p_s->people_id);
            }


            $specie['people'] = $list_people;
            $specie['homeworld'] = $homeworld;
        }
        return response()->json($species);
    }
    
/**
 * @OA\Get(
 *     path="/api/species/{id}",
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
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function read(string $id)
    {
        $species = Species::find($id);
        return response()->json($species);
    }

/**
 * @OA\Post(
 *     path="/api/species",
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
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
 *       description="ID du film",
 *       @OA\Schema(
 *       type="integer"
 *       )
 *   ),
 *     summary="Get a list of users",
 *     tags={"Species"},
 *     @OA\Response(response=400, description="Invalid request"),
 *     @OA\Response(response="200", description="Retourne la liste des films")
 * )
 */
    public function destroy(string $id)
    {
        $species = Species::find($id);
        $species->delete();
    }
}
