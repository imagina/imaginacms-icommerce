<?php

use Illuminate\Routing\Router;

Route::prefix('/manufacturers')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.icommerce.manufacturers.create',
        'uses' => 'ManufacturerApiController@create',
        'middleware' => ['auth:api', 'auth-can:icommerce.manufacturers.create'],
    ]);
    $router->get('/', [
        'as' => $locale.'api.icommerce.manufacturers.index',
        'uses' => 'ManufacturerApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.icommerce.manufacturers.update',
        'uses' => 'ManufacturerApiController@update',
        'middleware' => ['auth:api', 'auth-can:icommerce.manufacturers.edit'],
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.icommerce.manufacturers.delete',
        'uses' => 'ManufacturerApiController@delete',
        'middleware' => ['auth:api', 'auth-can:icommerce.manufacturers.destroy'],
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.icommerce.manufacturers.show',
        'uses' => 'ManufacturerApiController@show',
    ]);
});
