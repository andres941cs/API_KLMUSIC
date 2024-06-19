<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Message;
class UserController extends Controller
{
    # DEVUELVLE TODOS LOS USUARIOS DE LA BBDD
    public function index()
    {
        return User::all();
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

    # DEVUELVE LOS DATOS DE UN USUARIO
    public function profile(Request $request)
    {
        return response()->json($request->user, 200);
    }

    public function edit(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        if ($request->has('password') && $request->has('new_password')) {
            if(Hash::check($request->password, $user->password)){
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
                return response()->json("Password changed", 200);
            }else{
                return response()->json("Wrong Password", 400);
            }
        }

        if ($request->has('username') || $request->has('email')) {
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
            ]);
            return response()->json("Profile changed", 200);
        }
        
        return response()->json("DATA INVALID", 500);
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

    # ENVIA UN MENSAJE DE BIENVENIDA
    public function send(){
        # DATA
        $email = 'andrescs941@gmail.com';

        # MESSAGE
        $message = [
            'subject' => 'Bienvenido a la plataforma KLmusic',
            'content' => 'Gracias por registrarte en nuestra plataforma'
        ];

        Mail::to($email)->send(new Message($message['subject'], $message['content']));

        return response()->json("Mensaje enviado correctamente", 200);
    }
}
