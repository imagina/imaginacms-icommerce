<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/products'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.icommerce.products.create',
        'uses' => 'ProductApiController@create',
        'middleware' => ['auth:api','auth-can:icommerce.products.create']
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.icommerce.products.update',
        'uses' => 'ProductApiController@update',
        'middleware' => ['auth:api','auth-can:icommerce.products.edit']
    ]);
    $router->post('/rating/{criteria}', [
        'as' => 'api.icommerce.products.rating',
        'uses' => 'ProductApiController@rating',
        'middleware' => ['auth:api','auth-can:icommerce.products.rating']
    ]);
    $router->delete('/{criteria}', [
        'as' =>'api.icommerce.products.delete',
        'uses' => 'ProductApiController@delete',
        'middleware' => ['auth:api','auth-can:icommerce.products.destroy']
    ]);
    $router->get('/', [
        'as' =>'api.icommerce.products.index',
        'uses' => 'ProductApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.icommerce.products.show',
        'uses' => 'ProductApiController@show',
    ]);
    $router->post('import',[
        'as'=>'api.icommerce.products.import',
        'uses'=>'ProductApiController@importProducts',
         'middleware'=>['auth:api','auth-can:icommerce.products.import']
    ]);
    $router->post('/sync/{criteria}',[
        'as'=>'api.icommerce.products.sync',
        'uses'=>'ProductApiController@syncProducts',
        'middleware'=>['auth:api']
    ]);

});
