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

Route::resource('/cruds', 'CrudsController', [
    'except' => ['edit', 'show', 'store']
]);

Route::resource('/status', 'TicketController', [
    'except' => ['edit', 'show', 'store']
]);

Route::resource('/amend', 'CrudsController', [
    'except' => ['edit', 'show', 'store']
]);


Route::get('/status/{id}','TicketController@check');

Route::get('/cruds/create/{id}','CrudsController@create');

Route::get('/amend/{id}/{ticketLineNo}','CrudsController@amend');



