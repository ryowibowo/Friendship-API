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

$router->get('/test','UserController@test');
$router->post('/sendFriendRequest','UserController@sendFriendRequest');
$router->post('/acceptRequest','UserController@acceptRequest');
$router->post('/declineRequest','UserController@declineRequest');
$router->post('/blockRequest','UserController@blockRequest');
$router->get('/users','UserController@get');
$router->get('/userFriends','UserController@getFriends');
$router->get('/mutualFriends','UserController@mutualFriends');


// $router->get('/users','UserController@index');
$router->post('/users/register','UserController@create');
$router->patch('/users','UserController@update');

