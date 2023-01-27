<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')
    ->namespace('Registered')
    ->prefix('registered')
    ->name('registered.')
    ->group(function () {
        //Route::get('/', 'HomeController@index')->name('home');
        Route::resource('apartments', 'ApartmentsController');
        Route::resource('messages', 'MessagesController');
        Route::resource('services', 'ServicesController');
        //Route::resource('sponsorships', 'SponsorshipsController');
    });


    Route::get('/sponsorships', 'Registered\SponsorshipsController@index')->name('sponsorships.index');
    Route::get('/payment/{id}', 'Features\Payment\PaymentController@index')->name('payments.index');
    /* Route::post('payment/checkout', 'Payment\PaymentController@store' ); */
    Route::post('/checkout', 'Features\Payment\PaymentController@store')->name('payments.checkout');


// # tutte le altre rotte -> reindirizzale alla home dei guest
Route::get('{any?}', function () {
    return view('layouts.frontOffice');
})->where('any', '.*');
