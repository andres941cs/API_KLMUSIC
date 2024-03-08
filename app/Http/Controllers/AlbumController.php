<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    //
    public function index()
    {
        return Album::all();
    }

    public function show(string $id)
    {
        $album = Album::find($id);
        return response()->json($album);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id_artist' => 'required|exists:artists,id_artist',
            'release_date' => 'required|date',
            'genre' => 'required',
        ]);

        $album = Album::create($request->only(['name', 'id_artist', 'release_date', 'genre']));

        return response()->json($album, 201);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'album_name' => 'required',
            'id_artist' => 'required|exists:artists,id_artist',
            'release_date' => 'required|date',
            'genre' => 'required',
        ]);
        $album = Album::findOrFail($id);
        $album->update($request->only(['album_name', 'id_artist', 'release_date', 'genre']));

        return response()->json($album);
    }

    public function destroy(string $id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return response()->json(null, 204);
    }
}
