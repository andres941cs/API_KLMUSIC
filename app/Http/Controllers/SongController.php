<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    const UPLOAD_PATH = 'images/songs/';
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
        # SAVE IMG IN THE SERVER => PUBLIC/IMAGES/SONGS
        $file = $request->file('image');
        # GUARDARLO CON EL NOMBRE ORIGINAL
        //$fileName = $file->getClientOriginalName();
        # GUARDARLO CON EL NOMBRE ORIGINAL CON UN ID
        // $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $fileName = uniqid(). '_' .$request->name;
        $file->move(public_path(self::UPLOAD_PATH), $fileName);
        # CREAR UN INSTANCIA Y GUARDAR EN LA BBDD
        $song = new Song();
        $song->name = $request->name;
        $song->duration = $request->duration;
        $song->genre = $request->genre;
        $song->id_artist = $request->id_artist;
        // EL METODO URL => CONTENA LA URL DEL API CON RUTA DE LA IMAGEN    
        $song->image = url(self::UPLOAD_PATH . '/' . $fileName);
        $song->save();
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Search Song
     */
    public function search(Request $request)
    {
        # HAY DOS FORMAS DE USAR EL POST $request->input('campo'); || $request->campo
        $name = $request->input('search');
        //$order = $request->input('order', 'asc');//defaul ASC
        # CREAR UNA CONSULTA
        // $query = Song::query();
        $query = Song::with('artist');
        # APLICAR LOS FILTROS
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        # APLICAR ORDEN
        //$typeOrder = $request->input('typeOrder', 'title');//defaul ASC
        //$query->orderBy($typeOrder, $order);

        # APLICAR LA CONSULTA
        
        $songs = $query->get();
        
        return $songs;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // EL METODO ARTIST => AÑADE EL ARTISTA COMPLETO
        $song = Song::findOrFail($id);
        // SELECIONO EL CAMPO QUE QUIERO MOSTRAR
        $song->artist_name = $song->artist->name;
        // BORRO LOS DATOS QUE NO VOY A USAR DE LA RELACION
        unset($song->artist); 
        return $song;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # ECONTRAR LA CANCION A ACTUALIZAR
        $song = Song::findOrFail($id);
        # CAMPOS A ACTUALIZAR
        $dataToUpdate = $request->only(['name', 'duration', 'genre', 'id_artist']);
        # VERIFICAR LOS CAMPOS VACIOS
        if (empty($dataToUpdate)) {
            return response()->json(['error' => 'No se proporcionaron datos para actualizar'], 400);
        }
        # ACTUALIZAR LOS CAMPOS
        $song->update($dataToUpdate);
        return response()->json($song, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # BORRAR LA CANCION DE LA BBDD
        $song = Song::findOrFail($id);
        $song->delete();
        return response()->json("Song deleted Sucessfull", 204);
    }
}
