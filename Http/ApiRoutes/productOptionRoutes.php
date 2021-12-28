<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-option'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => 'api.icommerce.product-option.create',
        'uses' => 'ProductOptionApiController@create',
       'middleware' => ['auth:api','auth-can:icommerce.productoptions.create']
    ]);
    $router->get('/', [
        'as' => 'api.icommerce.product-option.index',
        'uses' => 'ProductOptionApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.icommerce.product-option.update',
        'uses' => 'ProductOptionApiController@update',
       'middleware' => ['auth:api','auth-can:icommerce.productoptions.edit']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.icommerce.product-option.delete',
        'uses' => 'ProductOptionApiController@delete',
       'middleware' => ['auth:api','auth-can:icommerce.productoptions.destroy']
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.icommerce.product-option.show',
        'uses' => 'ProductOptionApiController@show',
    ]);

    $router->post('/order', [
      'as' => 'api.icommerce.product-option.order',
      'uses' => 'ProductOptionApiController@updateOrder',
       'middleware' => ['auth:api','auth-can:icommerce.productoptions.edit']
    ]);

});
