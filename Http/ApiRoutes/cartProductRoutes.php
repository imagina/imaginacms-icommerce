<?php

use Illuminate\Routing\Router;

Route::prefix('/cart-products')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.icommerce.cart-products.create',
        'uses' => 'CartProductApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => $locale.'api.icommerce.cart-products.index',
        'uses' => 'CartProductApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.icommerce.cart-products.update',
        'uses' => 'CartProductApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.icommerce.cart-products.delete',
        'uses' => 'CartProductApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.icommerce.cart-products.show',
        'uses' => 'CartProductApiController@show',
    ]);
});
