<?php

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

$router->get('/', function() {
    return 'It\'s a test API. Login or has a Token is no needed';
});

$router->get('/medicals', 'MedicalController@index');
$router->get('/medicals/search', 'MedicalController@search');
$router->get('/medical/{id}/edit', 'MedicalController@edit');
$router->put('/medical/{id}', 'MedicalController@update');
$router->post('/medical', 'MedicalController@store');
$router->delete('/medical/{id}', 'MedicalController@destroy');
