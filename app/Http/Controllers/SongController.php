<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    const UPLOAD_PATH = 'public/images/songs/';
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
        // Song::create($request->all());
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path(self::UPLOAD_PATH), $fileName);
        $song = new Song();
        $song->name = $request->name;
        $song->duration = $request->duration;
        $song->genre = $request->genre;
        $song->id_artist = $request->id_artist;
        $song->image = self::UPLOAD_PATH . '/' . $fileName;
        $song->save();
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
