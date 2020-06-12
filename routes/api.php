<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

DB::listen(function($query) {
echo "<pre>{$query->sql} - {$query->time}</pre>";
});

*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::post('/logout', 'UserController@logout'); 

Route::get('invoices','Api\FctrasElctrncasInvoicesController@invoices');

Route::get('notes/cr','Api\FctrasElctrncasNotesCrController@creditNotes');
