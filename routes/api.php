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
Route::post('/login'            , 'TercerosUserController@login')->name('login');
Route::post('/logout'           , 'TercerosUserController@logout')->name('logout'); 
Route::post('/reset/password'   , 'TercerosUserController@resetPassword')->name('reset-password'); 
Route::post('/update/password'  , 'TercerosUserController@updatePassword')->name('update-password'); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//PRODUCTOS
Route::group(['prefix'=>'productos', 'namespace'=>'Api', 'middleware' => ['auth:sanctum']], function() {
        Route::get('/precios'                 , 'PrdctoController@listaPrecios')->name('lista-precios');
 });

//CARTERA CLIENTES CxC

Route::group(['prefix'=>'cartera', 'namespace'=>'Api'], function(){
    $localController = 'CarteraFacturasController@';
    Route::get('/clientes'                 , $localController.'clientesCxcPorVendedor');
    Route::get('/cliente/facturas'         , $localController.'facturasPorNit');
    Route::get('/vendedor/total'           , $localController.'totalPorVendedor');
 });

Route::group(['prefix'=>'ventas', 'namespace'=>'Api'], function(){
    $localController = 'BtcraVtasController@';
    Route::get('/vendedor'                 , $localController.'ventasVendedorUltimosDosAnios');
 });


// INVOICES
    Route::group(['prefix'=>'invoices', 'namespace'=>'Api'], function() {
        $localController = 'FctrasElctrncasInvoicesController@';
        Route:: get('/'                          , $localController.'invoices')->name('invoices');
        Route:: get('pdf/{id}'                   , $localController.'invoiceSendToCustomer');
        Route:: get('/download/{filetype}/{id}'  , $localController.'invoiceFileDownload');
        Route:: get('accepted/{id}'              , $localController.'invoiceAccepted');
        Route:: get('rejected/{id}'              , $localController.'invoiceRejected');
 
    });
 

Route::resource('facturas-electronicas', 'Api\FctrasElctrncaController', ['only'=> ['index', 'show', '']] );


   Route::group(['prefix'=>'productos', 'namespace'=>'Api'], function() {
        Route::get('/precios'           , 'PrdctoController@listaPrecios')->name('precios');
    });

// NOTES
    Route::group(['prefix'=>'notes', 'namespace'=>'Api'], function() {
        Route::get('pdf/{id}'             , 'FctrasElctrncasNotesCrController@noteSendToCustomer');
        Route::get('{tpNote}'             , 'FctrasElctrncasNotesCrController@notes');
    });
