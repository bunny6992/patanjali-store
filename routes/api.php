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

Route::post('bulk-add-products', 'Api\ApiController@bulkAddProducts');
Route::post('bulk-update-products', 'Api\ApiController@bulkUpdateProducts');

Route::resource('invoice', 'Api\InvoiceController');
Route::resource('expense', 'Api\ExpenseController');
Route::post('save-sales-returns', 'Api\ExpenseController@saveSalesReturn');
Route::get('print-invoice/{query}', 'Api\InvoiceController@printInvoice');
Route::get('print-closing/{query}', 'Api\InvoiceController@printClosing');
Route::post('update-items', 'Api\ApiController@updateItems');
