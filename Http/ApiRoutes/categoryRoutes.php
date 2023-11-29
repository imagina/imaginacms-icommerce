<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/categories'], function (Router $router) {

    $router->post('/', [
        'as' => 'api.icommerce.categories.create',
        'uses' => 'CategoryApiController@create',
        'middleware' => ['auth:api','auth-can:icommerce.categories.create']
    ]);
    $router->get('/', [
        'as' => 'api.icommerce.categories.index',
        'uses' => 'CategoryApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.icommerce.categories.show',
        'uses' => 'CategoryApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.icommerce.categories.update',
        'uses' => 'CategoryApiController@update',
        'middleware' => ['auth:api','auth-can:icommerce.categories.edit']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.icommerce.categories.delete',
        'uses' => 'CategoryApiController@delete',
        'middleware' => ['auth:api','auth-can:icommerce.categories.destroy']
    ]);

});
