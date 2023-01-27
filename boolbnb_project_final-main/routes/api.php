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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// # Set di rotte per ottenere liste e dettagli degli alloggi, e per ricerche custom degli alloggi
Route::namespace('Api')->group( function () {
    Route::get('/apartments/filter', 'ApartmentController@filter');
    Route::get('/apartments/sponsored', 'ApartmentController@sponsored');
    Route::get('/apartments/random', 'ApartmentController@random');
    Route::get('/apartments/search/{lat}&{lon}&{km}', 'ApartmentController@search');
    Route::resource('/apartments','ApartmentController');
});

// # Rotta per ottenere tutti i servizi
Route::get('/services', 'Api\ServicesController@index');

// # Rotta per il form dei contatti
Route::post('/contact', 'Api\ContactController@store');
