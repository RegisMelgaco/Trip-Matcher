<?php

/** @var \Illuminate\Routing\Router $router */

use Carbon\Carbon;

$router->get('trips', 'TripsController@index')->name('trips');
$router->get('trip/{consult_date}/{id}', 'TripsController@show')->name('trip');
$router->get('/', 'TripsController@indexToday')->name('tripsToday');

Auth::routes();