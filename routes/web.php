<?php

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

Route::get('/', 'TripsController@index')->name('tripsIndex');
Route::get('/{date}/{id}', 'TripsController@route')->name('tripRoute');

Auth::routes();