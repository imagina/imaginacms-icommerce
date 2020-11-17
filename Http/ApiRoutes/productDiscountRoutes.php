<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-discounts'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale . 'api.icommerce.product-discount.create',
        'uses' => 'ProductDiscountApiController@create',
    ]);
    $router->get('/', [
        'as' => $locale . 'api.icommerce.product-discount.index',
        'uses' => 'ProductDiscountApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.update',
        'uses' => 'ProductDiscountApiController@update',
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.delete',
        'uses' => 'ProductDiscountApiController@delete',
    ]);
    $router->get('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.show',
        'uses' => 'ProductDiscountApiController@show',
    ]);

    /*$router->post('/order', [
      'as' => $locale . 'api.icommerce.product-discount.order',
      'uses' => 'ProductDiscountApiController@updateOrder',
    ]);*/

});
