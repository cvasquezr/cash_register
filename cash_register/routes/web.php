<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/denomination', 'DenominationController@index');
$router->get('/denomination/{id}', 'DenominationController@show');
$router->post('/denomination', 'DenominationController@create');
$router->post('/denominations', 'DenominationController@createMany');
$router->put('/denomination/{id}', 'DenominationController@update');
$router->delete('/denomination/{id}', 'DenominationController@delete');
$router->put('/disabled/{id}', 'DenominationController@disabled');
