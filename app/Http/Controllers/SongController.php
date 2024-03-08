<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * DEVULEVE TODAS LAS CANCIONES DE LA BBDD
     */
    public function index()
    {
        return Song::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //response()->json($usuario, 200);
        Song::create($request->all());
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Song::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $song = Song::findOrFail($id);
        $song->update($request->all());
        return response()->json($song, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $song = Song::findOrFail($id);
        $song->delete();
        return response()->json("Song deleted Sucessfull", 204);
    }
}
