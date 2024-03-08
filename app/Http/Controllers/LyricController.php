<?php

namespace App\Http\Controllers;

use App\Models\Lyric;
use Illuminate\Http\Request;

class LyricController extends Controller
{
    /**
     * DEVULEVE TODAS LAS CANCIONES DE LA BBDD
     */
    public function index()
    {
        return Lyric::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Lyric::create($request->all());
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Lyric::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $lyric = Lyric::findOrFail($id);
        $lyric->update($request->all());
        return response()->json($lyric, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $lyric = Lyric::findOrFail($id);
        $lyric->delete();
        return response()->json("Song deleted Sucessfull", 204);
    }
}
