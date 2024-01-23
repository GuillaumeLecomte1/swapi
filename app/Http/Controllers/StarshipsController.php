<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Starships;

class StarshipsController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $starships = Starships::all();
        return response()->json($starships);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $starships = Starships::find($id);
        return response()->json($starships);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $starships = Starships::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $starships = Starships::find($id);
        $starships->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $starships = Starships::find($id);
        $starships->delete();
    }
}
