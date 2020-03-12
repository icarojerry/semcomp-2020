<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomePageController@index');

Route::get('/artistas', 'ArtistaController@index');
//Route::get('/artistas/{artista}', 'ArtistaController@show');
//Route::get('/artistas/{artista}/musicas/{musica}', 'ArtistaController@show');

Route::get('/musicas', 'MusicaController@index');
//Route::get('/musicas/{musica}', 'MusicaController@show');
//Route::get('/musicas/{musica}', 'MusicaController@show');
//
//Route::get('/compositores', 'CompositorController@index');
//Route::get('/compositores/{compositor}', 'CompositorController@show');
