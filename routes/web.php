<?php


use Illuminate\Support\Facades\Route;


Route::get('/', function (Request $request) {
    return view('welcome');
});

 
//FRASE DEL DÍA
Route::get('frase'          , 'FrasesController@sentenceToday');

//CONTACTOS
Route::post('contactos', 'TercerosContactatosController@saveContacto');