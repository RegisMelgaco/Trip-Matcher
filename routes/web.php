<?php

/** @var \Illuminate\Routing\Router $router */

$router->resource('trips', 'TripsController', ['only' => ['index', 'show']]);
$router->get('/', 'TripsController@index');

Auth::routes();