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
Route::post('/update/password'   , 'TercerosUserController@updatePassword')->name('update-password'); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



 

// INVOICES
Route::get('invoices','Api\FctrasElctrncasInvoicesController@invoices')->name('invoices');
Route::get('invoices/pdf/{id}'          , 'Api\FctrasElctrncasInvoicesController@invoiceSendToCustomer');
Route::get('invoices/accepted/{id}'     , 'Api\FctrasElctrncasInvoicesController@invoiceAccepted');
Route::get('invoices/rejected/{id}'     , 'Api\FctrasElctrncasInvoicesController@invoiceRejected');

Route::get('notes/pdf/{id}'          , 'Api\FctrasElctrncasNotesCrController@noteSendToCustomer');
Route::get('notes/{tpNote}','Api\FctrasElctrncasNotesCrController@notes');