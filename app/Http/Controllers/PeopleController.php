<?php
/**
 
openapi: 3.0.0  
@OA\Info(
version="1.0.0",
title="Documentation de l'API SWAPI",
description="API pour interagir avec SWAPI (Star Wars API)",
@OA\Contact(
email="contact@example.com"
)
)
*/
namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $people = People::all();
        return response()->json($people);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $people = People::find($id);
        return response()->json($people);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $people = People::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $people = People::find($id);
        $people->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $people = People::find($id);
        $people->delete();
    }
}
