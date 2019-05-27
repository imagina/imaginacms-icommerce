<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/products'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.icommerce.products.create',
        'uses' => 'ProductApiController@create',
        'middleware' => ['auth:api']
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.icommerce.products.update',
        'uses' => 'ProductApiController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{criteria}', [
        'as' =>'api.icommerce.products.delete',
        'uses' => 'ProductApiController@delete',
        'middleware' => ['auth:api']
    ]);
    $router->get('/', [
        'as' =>'api.icommerce.products.index',
        'uses' => 'ProductApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.icommerce.products.show',
        'uses' => 'ProductApiController@show',
    ]);

});