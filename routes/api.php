<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('getItems/{query}', 'Api/ApiController@getItems');

Route::get('get-items/{query}', 'Api\ApiController@getItems');
Route::get('get-all-items', 'Api\ApiController@getAllItems');
Route::resource('invoice', 'Api\InvoiceController');
Route::get('print-invoice/{query}', 'Api\InvoiceController@printInvoice');
Route::post('update-items', 'Api\ApiController@updateItems');
