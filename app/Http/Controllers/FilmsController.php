<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Films;

class FilmsController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function readAll()
    {
        $films = Films::all();
        return response()->json($films);
    }
    
    /**
     * Display the specified resource.
     */
    public function read(string $id)
    {
        $films = Films::find($id);
        return response()->json($films);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $films = Films::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $films = Films::find($id);
        $films->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $films = Films::find($id);
        $films->delete();
    }
}
