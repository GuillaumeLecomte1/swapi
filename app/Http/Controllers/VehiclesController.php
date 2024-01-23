<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;

class VehiclesController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $vehicles = Vehicles::all();
        return response()->json($vehicles);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $vehicles = Vehicles::find($id);
        return response()->json($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $vehicles = Vehicles::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicles = Vehicles::find($id);
        $vehicles->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicles = Vehicles::find($id);
        $vehicles->delete();
    }
}
