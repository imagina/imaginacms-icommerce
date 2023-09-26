<?php

use Illuminate\Routing\Router;

Route::prefix('/order-status-history')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.icommerce.order-status-history.create',
        'uses' => 'OrderStatusHistoryApiController@create',
        'middleware' => ['auth:api', 'auth-can:icommerce.orderhistories.create'],
    ]);
    $router->get('/', [
        'as' => $locale.'api.icommerce.order-status-history.index',
        'uses' => 'OrderStatusHistoryApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.icommerce.order-status-history.update',
        'uses' => 'OrderStatusHistoryApiController@update',
        'middleware' => ['auth:api', 'auth-can:icommerce.orderhistories.edit'],
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.icommerce.order-status-history.delete',
        'uses' => 'OrderStatusHistoryApiController@delete',
        'middleware' => ['auth:api', 'auth-can:icommerce.orderhistories.destroy'],
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.icommerce.order-status-history.show',
        'uses' => 'OrderStatusHistoryApiController@show',
    ]);
});
