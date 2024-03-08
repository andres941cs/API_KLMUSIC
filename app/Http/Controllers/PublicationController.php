<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    # DEVUELVLE TODOS LOS PUBLICACIONES DE LA BBDD
    public function index()
    {
        $publications = Publication::all();
        return  response()->json($publications);
    }

    # GUARDA UNA PUBLICACION EN LA BBDD
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     "username"=>"required|string|unique:users",
        // ]);

        Publication::create($request->all());
        return response()->json(["message"=>"Publication created successfully"]);
    }

    # DEVUELVE UNA PUBLICACION USUARIO POR ID
    public function show(string $id)
    {
        return Publication::find($id);
    }

    # ACTUALIZA UNA PUBLICACION - PARAMETROS: REQUEST, ID
    public function update(Request $request, string $id)
    {
        $publication = Publication::findOrFail($id);
        $publication->update($request->all());
        return response()->json($publication, 200);
    }

    # ELIMINA UN USUARIO DE LA BBDD
    public function destroy(string $id)
    {
        $publication = Publication::findOrFail($id);
        $publication->delete();
        return response()->json("Usuario eliminado correctamente", 204);
    }
}
