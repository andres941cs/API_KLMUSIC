<?php

namespace App\Http\Controllers;

use App\Models\Karaoke;
use Illuminate\Http\Request;

class KaraokeController extends Controller
{
    /**
     * DEVULEVE TODAS LAS CANCIONES DE LA BBDD
     */
    public function index()
    {
        return Karaoke::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Karaoke::create($request->all());
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Karaoke::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $karaoke = Karaoke::findOrFail($id);
        $karaoke->update($request->all());
        return response()->json($karaoke, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $karaoke = Karaoke::findOrFail($id);
        $karaoke->delete();
        return response()->json("Song deleted Sucessfull", 204);
    }
}
