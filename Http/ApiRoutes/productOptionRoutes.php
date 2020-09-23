<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-option'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => 'api.icommerce.product-option.create',
        'uses' => 'ProductOptionApiController@create',
    ]);
    $router->get('/', [
        'as' => 'api.icommerce.product-option.index',
        'uses' => 'ProductOptionApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.icommerce.product-option.update',
        'uses' => 'ProductOptionApiController@update',
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.icommerce.product-option.delete',
        'uses' => 'ProductOptionApiController@delete',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.icommerce.product-option.show',
        'uses' => 'ProductOptionApiController@show',
    ]);

    $router->post('/order', [
      'as' => 'api.icommerce.product-option.order',
      'uses' => 'ProductOptionApiController@updateOrder',
    ]);

});
