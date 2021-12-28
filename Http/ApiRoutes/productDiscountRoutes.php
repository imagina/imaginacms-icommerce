<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-discounts'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale . 'api.icommerce.product-discount.create',
        'uses' => 'ProductDiscountApiController@create',
       'middleware' => ['auth:api','auth-can:icommerce.productdiscounts.create']
    ]);
    $router->get('/', [
        'as' => $locale . 'api.icommerce.product-discount.index',
        'uses' => 'ProductDiscountApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.update',
        'uses' => 'ProductDiscountApiController@update',
       'middleware' => ['auth:api','auth-can:icommerce.productdiscounts.edit']
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.delete',
        'uses' => 'ProductDiscountApiController@delete',
       'middleware' => ['auth:api','auth-can:icommerce.productdiscounts.destroy']
    ]);
    $router->get('/{criteria}', [
        'as' => $locale . 'api.icommerce.product-discount.show',
        'uses' => 'ProductDiscountApiController@show',
    ]);

});
