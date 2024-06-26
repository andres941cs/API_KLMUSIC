<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaraokeController;
use App\Http\Controllers\LyricController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController;
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


# RUTAS AUTHENTICATE
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/activate/{id}', [AuthController::class, 'activate']);
Route::post('/reset', [AuthController::class, 'reset']);
Route::post('/forgot', [AuthController::class, 'forgot']);

# RUTAS USERS
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::get('/send', [UserController::class, 'send']);

# RUTAS SONGS
Route::get('/songs', [SongController::class, 'index']);
Route::get('/song', [SongController::class, 'all']);
Route::post('/song', [SongController::class, 'store']);
Route::get('/song/{id}', [SongController::class, 'show']);
Route::get('/song/artist/{id}', [SongController::class, 'showByArtist']);
Route::get('/song/album/{id}', [SongController::class, 'showByAlbum']);
Route::put('/song/{id}', [SongController::class, 'update']);
Route::delete('/song/{id}', [SongController::class, 'destroy']);
Route::post('/song/search', [SongController::class, 'search']);

# RUTAS ARTIST
Route::get('/artist', [ArtistController::class, 'index']);
Route::get('/artist/{id}', [ArtistController::class, 'show']);
Route::post('/artist', [ArtistController::class, 'store']);
Route::put('/artist/{id}', [ArtistController::class, 'update']);
Route::delete('/artist/{id}', [ArtistController::class, 'destroy']);
Route::post('/artist/search', [ArtistController::class, 'search']);

# RUTAS ALBUM
Route::get('/album', [AlbumController::class, 'index']);
Route::get('/album/{id}', [AlbumController::class, 'show']);
Route::get('/album/artist/{id}', [AlbumController::class, 'showByArtist']);
Route::post('/album/search', [AlbumController::class, 'search']);
Route::post('/album', [AlbumController::class, 'store']);
Route::put('/album/{id}', [AlbumController::class, 'update']);
Route::delete('/album/{id}', [AlbumController::class, 'destroy']);

# RUTAS LYRICS
Route::get('/lyric', [LyricController::class, 'index']);
Route::post('/lyric', [LyricController::class, 'store']);
Route::put('/lyric/{id}', [LyricController::class, 'update']);
Route::delete('/lyric/{id}', [LyricController::class, 'destroy']);
Route::get('/lyric/song/{id}', [LyricController::class, 'showLyricsBySong']);

# RUTAS KARAOKE
Route::get('/karaoke', [KaraokeController::class, 'index']);
Route::get('/karaoke/{id}', [KaraokeController::class, 'show']);
Route::get('/karaoke/user/{id}', [KaraokeController::class, 'showByUser']);
Route::post('/karaoke', [KaraokeController::class, 'store']);
Route::put('/karaoke/{id}', [KaraokeController::class, 'update']);
Route::delete('/karaoke/{id}', [KaraokeController::class, 'destroy']);
Route::get('/karaoke/search/{name}', [KaraokeController::class, 'search']);
Route::get('/random/karaoke', [KaraokeController::class, 'random']);
Route::get('/karaokes', [KaraokeController::class, 'all']);

# RUTAS ROLES
Route::post('/form/song', [SongController::class, 'save']);
Route::post('/form/album', [AlbumController::class, 'save']);
Route::post('/form/artist', [ArtistController::class, 'save']);
// Route::post('/form/lyric', [LyricController::class, 'store']);
Route::get('/artists', [ArtistController::class, 'all']);
Route::get('/albums', [AlbumController::class, 'all']);


# RUTAS PROTEGIDAS
Route::put('/user/karaoke/visibility/{id}', [KaraokeController::class, 'changeVisibility'])->middleware('auth');
Route::delete('/user/karaoke/{id}', [KaraokeController::class, 'destroy'])->middleware('auth');
Route::get('/unverified/songs', [SongController::class, 'unverified']);
Route::get('/unverified/albums', [AlbumController::class, 'unverified']);
Route::get('/unverified/artists', [ArtistController::class, 'unverified']);

Route::get('/profile', [UserController::class, 'profile'])->middleware('auth');
Route::put('/profile/{id}', [UserController::class, 'edit'])->middleware('auth');