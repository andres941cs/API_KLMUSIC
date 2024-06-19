<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Mail;
use App\Mail\Message;
use Illuminate\Support\Facades\Crypt;
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

        # DATA
        $email = $request->email;
        $id = Crypt::encrypt($user->id);
        # MESSAGE
        $message = [
            'subject' => 'Bienvenido a la plataforma KLmusic',
            'content' => 'Gracias por registrarte en nuestra plataforma para activar la cuenta 
            haz click en el siguiente enlace: '. env('APP_URL') .'/api/activate/'.$id
        ];

        Mail::to($email)->send(new Message($message['subject'], $message['content']));

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

    // ACTIVAR USUARIO
    public function activate(string $id)
    {
        $decryptedId = Crypt::decrypt($id);
        $user = User::findOrFail($decryptedId);
        $user->update(['role' => 'member']);
        return view('activate');
    }

    // FORGOT PASSWORD
    public function forgot(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $id = Crypt::encrypt($user->id);
        if ($user) {
            $message = [
                'subject' => 'Recuperar contraseña',
                'content' => 'Para recuperar tu contraseña haz click en el siguiente enlace: '. env('APP_URL') .'/reset/'.$id
            ];
            Mail::to($email)->send(new Message($message['subject'], $message['content']));
            return response()->json(["message"=>"Email sent successfully"]);
        } else {
            return response()->json(["message"=>"Email not found"]);
        }
    }

    // RESET PASSWORD
    public function reset(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $password = $request->password;
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($password)]);
        return view('reset');
    }
}
