<?php
use App\User;
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

/**
* client -users  [0]
* server - admin [1]
* [0]
*/

//  authentication
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->post('/update-user', 'AuthController@update');

$router->post('/reset', 'UserController@sendResetToken');
$router->post('/reset/password', 'UserController@verifyResetPassword');

// KUIS VIEW
$router->get('/show-kuis', 'KuisController@showKuis');
$router->post('/show-kuis-detail', 'KuisController@showKuisDetail');

// NILAI KUIS
$router->post('/after-kuis', 'NilaiKuisController@insert');
$router->post('/nilai-kuis', 'NilaiKuisController@showNilai');
