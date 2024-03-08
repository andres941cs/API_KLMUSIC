<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Artist::all();
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Artist::create($request->all());
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Artist::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $artist = Artist::findOrFail($id);
        $artist->update($request->all());
        return response()->json($artist, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return response()->json("Artist deleted Sucessfull", 204);
    }
}
