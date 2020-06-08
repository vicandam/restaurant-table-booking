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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('all-booking', 'BookingController@index')->name('all.booking');
Route::get('new-booking', 'BookingController@newBooking')->name('new.booking');
Route::get('confirmed-booking', 'BookingController@confirmedBooking')->name('confirmed.booking');
Route::get('booking', 'BookingController@customerBooking')->name('customer.booking');
Route::get('table', 'TableController@index')->name('table');

Route::group(['middleware' => 'auth:web'], function() {
    Route::name('api.')->prefix('api')->group(function() {
        Route::resource('table', 'api\TableController');
        Route::resource('booking', 'api\BookingController');

        Route::get('confirmed-booking', 'api\BookingController@confirmedBooking')->name('booking.confirmed');
        Route::get('pending-booking', 'api\BookingController@pendingBooking')->name('booking.pending');
    });
});
