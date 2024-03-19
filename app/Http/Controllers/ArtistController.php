<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    const UPLOAD_PATH = 'public/images/artists/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Artist::all();
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # SAVE IMG IN THE SERVER => PUBLIC/IMAGES/ARTISTS
        $file = $request->file('image');
        # GUARDARLO CON EL NOMBRE ORIGINAL CON UN ID
        $fileName = uniqid(). '_' .$request->name . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(self::UPLOAD_PATH), $fileName);
        # CREAR UN INSTANCIA Y GUARDAR EN LA BBDD
        $artist = new Artist();
        $artist->name = $request->name;
        $artist->country = $request->country;
        $artist->verified = $request->verified;
        // EL METODO URL => CONTENA LA URL DEL API CON RUTA DE LA IMAGEN    
        $artist->image = self::UPLOAD_PATH . '/' . $fileName;
        $artist->save();
        return response()->json("Created Sucessfull", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Artist::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $artist = Artist::findOrFail($id);
        $artist->update($request->all());
        return response()->json($artist, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $artist = Artist::findOrFail($id);
        if (file_exists($artist->image)) {
            unlink($artist->image);
        }
        $artist->delete();
        return response()->json("Artist deleted Sucessfull", 204);
    }
}
