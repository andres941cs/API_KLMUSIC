<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class ArtistController extends Controller
{
    const UPLOAD_PATH = '/images/artists';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Artist::all();
    }

    public function all()
    {
        // DEVUELVLE TODOS LOS ARTISTAS DE LA BBDD QUE ESTAN VERIFICADOS
        return Artist::where('verified', true)->get();
    }

    public function unverified()
    {
        // DEVUELVLE TODOS LOS ARTISTAS DE LA BBDD QUE NO ESTAN VERIFICADOS
        return Artist::where('verified', false)->get();
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
        $file->move(public_path('/images/artists/'), $fileName);
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

    public function search(Request $request)
    {
        # HAY DOS FORMAS DE USAR EL POST $request->input('campo'); || $request->campo
        $name = $request->input('name');
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

    public function save(Request $request)
    {
        // AUTO CREATE ARTIST
        if ($request->has('id')) {
            $client = new Client();
            $response = $client->request('GET', env('API_SERVICE_URL') . '/artist/' . $request->id);
            $data = json_decode($response->getBody(), true);
            // COMPROBAR QUE LOS DATOS SON IGUALES AL DE LA PETICION
            if ($data['name'] == $request->name && $data['country'] == $request->country && $data['image'] == $request->image){
                return response()->json("Correcto", 200);
            }else{
                return response()->json(["error"=>"Datos Invalidos"], 200);
            }   
        }else{
            // MANUALLY CREATE ARTIST
            $artist = new Artist();
            $artist->name = $request->name;
            $artist->country = $request->country;
            $artist->verified = false;
            $artist->image = $request->image;
            $artist->save();
        }
        return response()->json("Created Sucessfull", 200);
    }
}
