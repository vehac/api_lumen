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

$router->get('/api/v1/doc', function () {
    return view('swagger.index');
});

$router->get('/api/v1/doc_json', function () {
    require(__DIR__ . "/../vendor/autoload.php");
    $openapi = \OpenApi\Generator::scan([__DIR__ . '/../app/Http/Controllers/', __DIR__ . '/../app/Models/']);
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

$router->post('/api/v1/generate-token', 'AuthController@generateToken');
$router->get('/api/v1/clients', 'ClientController@index');
$router->get('/api/v1/clients/{id}', 'ClientController@show');

////$router->post('/api/v1/verify-token',  [ 'middleware' => 'jwt_auth', 'uses' => 'AuthController@verifyToken']);
$router->group(['middleware' => 'jwt_auth'], function () use ($router) {
    $router->post('/api/v1/verify-token', 'AuthController@verifyToken');
    $router->post('/api/v1/clients', 'ClientController@create');
    $router->post('/api/v1/clients/{id}', 'ClientController@update');
    $router->delete('/api/v1/clients/{id}', 'ClientController@delete');
});

