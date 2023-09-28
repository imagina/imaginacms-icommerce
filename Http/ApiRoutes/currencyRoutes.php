<?php

use Illuminate\Routing\Router;

Route::prefix('/currencies')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.icommerce.currencies.create',
        'uses' => 'CurrencyApiController@create',
        'middleware' => ['auth:api', 'auth-can:icommerce.currencies.create'],
    ]);
    $router->get('/', [
        'as' => $locale.'api.icommerce.currencies.index',
        'uses' => 'CurrencyApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.icommerce.currencies.update',
        'uses' => 'CurrencyApiController@update',
        'middleware' => ['auth:api', 'auth-can:icommerce.currencies.edit'],
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.icommerce.currencies.delete',
        'uses' => 'CurrencyApiController@delete',
        'middleware' => ['auth:api', 'auth-can:icommerce.currencies.destroy'],
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.icommerce.currencies.show',
        'uses' => 'CurrencyApiController@show',
    ]);
});
