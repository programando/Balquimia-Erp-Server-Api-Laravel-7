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

Route::get('/', function () {
    return view('welcome');
});



Route::get('mail', function () {

    return view('mails.invoices.ToCustomer');
});

// INVOICES
Route::get('invoices/pdf/{id}'          , 'Api\FctrasElctrncasInvoicesController@invoiceSendToCustomer');
Route::get('invoices/accepted/{id}'     , 'Api\FctrasElctrncasInvoicesController@invoiceAccepted');
Route::get('invoices/rejected/{id}'     , 'Api\FctrasElctrncasInvoicesController@invoiceRejected');