<?php


use Illuminate\Support\Facades\Route;

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
Route::post('/login'            , 'TercerosUserController@login')->name('login');
Route::post('/logout'           , 'TercerosUserController@logout')->name('logout'); 
Route::post('/reset/password'   , 'TercerosUserController@resetPassword')->name('reset-password'); 
Route::post('/update/password'   , 'TercerosUserController@updatePassword')->name('update-password'); 

//Route::post('/register' , 'UserController@register');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//FRASE DEL DÍA
Route::get('frase'          , 'FrasesController@sentenceToday');