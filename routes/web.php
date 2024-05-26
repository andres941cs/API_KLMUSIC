<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activate', function () {
    return view('activate');
});

Route::get('/reset/{id}', function ($id) {
    $decryptedId = Crypt::decrypt($id);
    return view('resetPassword',['id' => $id]);
});

Route::get('/reset', function () {
    return view('reset');
});
