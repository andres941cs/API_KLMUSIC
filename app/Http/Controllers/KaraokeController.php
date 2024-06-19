<?php

namespace App\Http\Controllers;

use App\Models\Karaoke;
use Illuminate\Http\Request;

class KaraokeController extends Controller
{
    /**
     * DEVULEVE TODAS LOS KARAOKES DE LA BBDD
     */
    public function index()
    {
        return Karaoke::all();
    }

    public function all()
    {
        $karaokes = Karaoke::where('isPublished', true)->with('lyric.song.artist' , 'lyric.song.album')->get();
        $songs = [];
        foreach ($karaokes as $karaoke) {
            $song = $karaoke->lyric->song;
            $song->id_karaoke = $karaoke->id;
            $song->isInstrumental = $karaoke->lyric->isInstrumental;
            $song->language = $karaoke->lyric->language;
            $songs[] = $song;
        }
        return response()->json($songs, 200);
    }

    public function showByUser(string $id)
    {
        $karaoke = Karaoke::where('id_user', $id)->get()->load('lyric.song.artist');
        if ($karaoke->isEmpty()) {
            return response()->json(['message' => 'No matching karaoke entries found'], 404);
        }
        return response()->json($karaoke, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Karaoke::create($request->all());
        return response()->json("Created Sucessfull", 200);
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        $karaoke = Karaoke::whereHas('lyric.song', function ($query) use ($name) {
            $query->where('name', 'like', "%$name%");
            $query->where('verified', true);
        })->get()->load('lyric.song.artist');
    
        // if ($karaoke->isEmpty()) {
        //     return response()->json(['message' => 'No matching karaoke entries found'], 200);
        // }
        return response()->json($karaoke, 200);
    }

    public function getByGenre(string $genre)
    {
        $karaokes = Karaoke::whereHas('lyric.song', function ($query) use ($genre) {
            $query->where('genre', $genre);
            $query->where('verified', true);
        })->get()->load('lyric.song.artist');

        return response()->json($karaokes, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karaoke = Karaoke::find($id);
        $karaoke->load('Lyric.Song');
        return $karaoke;
    }

    public function random()
    {
        return Karaoke::inRandomOrder()->first();
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

    public function changeVisibility(string $id)
    {
        $karaoke = Karaoke::findOrFail($id);
        $karaoke->update([
            'isPublished' => !$karaoke->isPublished
        ]);
        return response()->json("Change Visibility Sucessfull", 200);
    }

}
