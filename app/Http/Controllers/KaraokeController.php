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

    public function search(string $name)
    {
        // $karaoke = Karaoke::whereHas('Song', function ($query) use ($name) {
        //     $query->where('name', 'like', "%$name%");
        // })->get();

        $karaoke = Karaoke::whereHas('lyric.song', function ($query) use ($name) {
            $query->where('name', 'like', "%$name%");
        })->get();
    
        
        if ($karaoke->isEmpty()) {
            return response()->json(['message' => 'No matching karaoke entries found'], 404);
        }
        return response()->json($karaoke, 200);
    }
    

    /**
     * Display a random resource.
     */
    public function random()
    {
        return Karaoke::inRandomOrder()->first();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karaoke = Karaoke::find($id);
        $karaoke->load('Lyric.Song');
        // $karaoke->unset('id_lyric');
        return $karaoke;
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
