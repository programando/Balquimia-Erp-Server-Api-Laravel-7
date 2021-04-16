<?php
use Illuminate\Support\Facades\Route;

/* DB::listen(function($query) {
echo "<pre>{$query->sql} - {$query->time}</pre>";
});
 */
Route::get('/', function (Request $request) {
    return view('welcome');
});

 
//FRASE DEL DÍA
Route::get('frase'          , 'FrasesController@sentenceToday');

//CONTACTOS
Route::post('contactos', 'TercerosContactatosController@saveContacto');