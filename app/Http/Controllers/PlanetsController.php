<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planets;

class PlanetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $planet = Planets::all();
        return response()->json($planet);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $planet = Planets::find($id);
        return response()->json($planet);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $planet = Planets::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $planet = Planets::find($id);
        $planet->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $planet = Planets::find($id);
        $planet->delete();
    }
}
