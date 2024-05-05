<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use UnexpectedValueException;
use App\Models\User;

class Authenticate
{
    # MIDDLEWARE => COMPRUEBA SI RECUPERA UN TOKEN VALIDO
    public function handle(Request $request, Closure $next): Response
    {
        // ERROR - SI LA PETICION NO TIENE TOKEN 
        if(!$request->header('Authorization')){
            return response()->json([
                'error'=>'SER REQUIERE UN TOKEN'
            ],401);
        }
        // OBTENER EL TOKEN DE LA CABEZERA
        $array_token = explode(' ',$request->header('Authorization'));
        $token = $array_token[1];

        // ERROR - FORMATO DEL TOKEN INVALIDO
        if (count($array_token) !== 2) {
            //throw new InvalidTokenException('Formato de token inválido', 400);
            return response()->json([
                'error'=>'FORMANTO DEL TOKEN INVALIDO'
            ],401);
        }

        try{
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        }catch(ExpiredException $e){
            return response()->json([
                'error'=>'TOKEN EXPIRADO'
            ],400);
        }catch(UnexpectedValueException $e){
            return response()->json([
                'error'=>'ERROR INESPERADO'
            ],400);
        }
        $user = User::find($credentials->sub->id);
        if (!$user) {
            return response()->json([
                'error'=>'Usuario no encontrado'
            ],404);
        }
        //$request->auth = $user;

        $request->merge(['user' => $user]);
        return $next($request);
    }
}
