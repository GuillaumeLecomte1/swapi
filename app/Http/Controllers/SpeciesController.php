<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;

class SpeciesController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $species = Species::all();
        return response()->json($species);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $species = Species::find($id);
        return response()->json($species);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $species = Species::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $species = Species::find($id);
        $species->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $species = Species::find($id);
        $species->delete();
    }
}
