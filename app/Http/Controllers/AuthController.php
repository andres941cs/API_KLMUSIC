<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    # REGISTRAR UN USUARIO EN LA BBDD
    public function register(Request $request)
    {
        # Validar datos del usuario
        $validator = Validator::make($request->all(), [
            "username" => "required|string|unique:users",
            "email" => "required|email|string|unique:users",
            "password" => "required|string|min:8|confirmed",
        ]);
        # Si el validador falla devuelve un error
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        # Crear usuario
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //$token = $user->createToken('MyApp')->accessToken;
        //return response(['token' => $token], 200);
        return response()->json(["message"=>"Usuario creado correctamente"]);
    }

    public function login(Request $request)
    {
        # Validar credenciales del usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            # Generar token JWT
            $payload = [
                'iss' => 'API_KLMUSIC_JWT',
                'iat' => time(),
                'exp' => time() + 60*60,
                'sub' => $user,
            ];
            $token = JWT::encode($payload, env('JWT_SECRET'),'HS256');
            # PENDIENTE => GUARDAR EL TOKEN EN LA BBDD
            return response(['token' => $token], 200);
        } else {
            return response(['error' => 'Credenciales incorrectas'], 401);
        }
    }
}
