<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    const UPLOAD_PATH = '/images/albums/';
    //
    public function index()
    {
        $albums = Album::with('artist')->get();
        return $albums;
    }

    public function show(string $id)
    {
        $album = Album::find($id);
        return response()->json($album);
    }

    public function showByArtist(string $id)
    {
        $albums = Album::where('id_artist', $id)->get();
        return response()->json($albums);
    }

    public function search(Request $request)
    {
        # HAY DOS FORMAS DE USAR EL POST $request->input('campo'); || $request->campo
        $name = $request->input('search');
        //$order = $request->input('order', 'asc');//defaul ASC
        # CREAR UNA CONSULTA
        $query = Artist::query();
        // $query = Artist::with('artist');
        # APLICAR LOS FILTROS
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        # APLICAR ORDEN
        //$typeOrder = $request->input('typeOrder', 'title');//defaul ASC
        //$query->orderBy($typeOrder, $order);

        # APLICAR LA CONSULTA
        
        $artists = $query->get();
        
        return $artists;
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'id_artist' => 'required|exists:artists,id_artist',
        //     'release_date' => 'required|date',
        //     'genre' => 'required',
        // ]);

        # SAVE IMG IN THE SERVER => PUBLIC/IMAGES/ARTISTS
        $file = $request->file('image');
        # GUARDARLO CON EL NOMBRE ORIGINAL CON UN ID
        $fileName = uniqid(). '_' .$request->name . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/images/albums/'), $fileName);
        # CREAR UN INSTANCIA Y GUARDAR EN LA BBDD
        Album::create([
            'name' => $request->name,
            'release_date' => $request->release_date,
            'genre' => $request->genre,
            'id_artist' => $request->id_artist,
            'image' =>  self::UPLOAD_PATH . '/' . $fileName
        ]);
        return response()->json("Created Sucessfull", 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'id_artist' => 'required|exists:artists,id',
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
