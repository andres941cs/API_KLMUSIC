<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SongController extends Controller
{
    const UPLOAD_PATH = 'images/songs/';
    /**
     * DEVULEVE TODAS LAS CANCIONES DE LA BBDD
     */
    public function index()
    {
        $songs = Song::with('artist', 'album')->get();
        return $songs;
    }

    public function all()
    {
        // DEVULEVE TODAS LAS CANCIONES DE LA BBDD QUE ESTEN VERIFICADAS
        $songs = Song::where('verified', true)->with('artist', 'album')->get();
        return $songs;
    }

    public function unverified()
    {
        // DEVULEVE TODAS LAS CANCIONES DE LA BBDD QUE NO ESTEN VERIFICADAS
        $songs = Song::where('verified', false)->with('artist', 'album')->get();
        return $songs;
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
        $name = $request->input('name');
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
        $dataToUpdate = $request->only(['name', 'duration', 'genre', 'id_artist', 'id_album', 'image', 'verified']);
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


    public function showByArtist(string $id)
    {
        $songs = Song::where('id_artist', $id)->with('artist', 'album')->get();
        return $songs;
    }
    public function showByAlbum(string $id)
    {
        $songs = Song::where('id_album', $id)->with('artist', 'album')->get();
        return $songs;
    }

    public function save(Request $request)
    {
        // AUTO CREATE ALBUM
        if ($request->has('id')) {
            $client = new Client();
            $response = $client->request('GET', env('API_SERVICE_URL') . '/song/' . $request->id);
            $data = json_decode($response->getBody(), true);
            // COMPROBAR QUE LOS DATOS SON IGUALES AL DE LA PETICION
            if ($data['name'] == $request->name && $data['duration'] == $request->duration && $data['image'] == $request->image){
                Song::create([
                    'name' => $request->name,
                    'genre' => $request->genre,
                    'duration' => $request->duration,
                    'id_artist' => $request->id_artist,
                    'id_album' => $request->id_album,
                    'image' =>  $request->image,
                    'verified' => true
                ]);
                return response()->json("Created Sucessfull", 200);
            }else{
                return response()->json(["error"=>"Invalid data"], 200);
            }   
        }else{
            // Validar que el album pertenece al artista
            if($request->id_album){
                # BUSCAR EL ALBUM
                $album = Album::findOrFail($request->id_album);
                # VERIFICAR QUE EL ALBUM PERTENECE AL ARTISTA
                if ($album->id_artist != $request->id_artist) {
                    return response()->json(["error" => "Album does not belong to the artist"], 200);
                }
            }

            // MANUALLY CREATE ARTIST
            $song = new Song();
            $song->name = $request->name;
            $song->duration = $request->duration;
            $song->image = $request->image;
            $song->genre = $request->genre;
            $song->id_artist = $request->id_artist;
            $song->id_album = $request->id_album;
            $song->save();
        }
        return response()->json("Created Sucessfull", 200);
    }
}
