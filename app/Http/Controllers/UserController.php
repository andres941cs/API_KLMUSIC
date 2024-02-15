<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    # DEVUELVLE TODOS LOS USUARIOS DE LA BBDD
    public function index()
    {
        $users = User::all();
        return $users->toJson(JSON_PRETTY_PRINT);
    }

    # GUARDA UN USUARIO EN LA BBDD
    public function store(Request $request)
    {
        $this->validate($request,[
            "username"=>"required|string|unique:users",
            "email"=>"required|email|string|unique:users",
            "password"=>"required",
            "role"=>"required"
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(["message"=>"Usuario creado correctamente"]);
    }

    # DEVUELVE UN USUARIO POR ID
    public function show(string $id)
    {
        return User::find($id);
    }

    # ACTUALIZA UN USUARIO - PARAMETROS: REQUEST, ID
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update($request->all());
        return response()->json($usuario, 200);
    }

    # ELIMINA UN USUARIO DE LA BBDD
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return response()->json("Usuario eliminado correctamente", 204);
    }
}
