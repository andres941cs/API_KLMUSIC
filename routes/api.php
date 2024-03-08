<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/  

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# RUTAS AUTHENTICATE
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

# RUTAS USERS
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

# RUTAR PROFILES

# RUTAS SONGS
Route::get('/songs', [SongController::class, 'index']);
Route::post('/song', [SongController::class, 'store']);
Route::put('/song/{id}', [SongController::class, 'update']);
Route::delete('/song/{id}', [SongController::class, 'destroy']);

# RUTAS ARTIST
Route::get('/artist', [ArtistController::class, 'index']);
Route::post('/artist', [ArtistController::class, 'store']);