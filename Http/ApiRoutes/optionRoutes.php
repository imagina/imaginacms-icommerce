<?php

use Illuminate\Routing\Router;

Route::prefix('/options')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.icommerce.options.create',
        'uses' => 'OptionApiController@create',
        'middleware' => ['auth:api', 'auth-can:icommerce.options.create'],
    ]);
    $router->get('/', [
        'as' => $locale.'api.icommerce.options.index',
        'uses' => 'OptionApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.icommerce.options.update',
        'uses' => 'OptionApiController@update',
        'middleware' => ['auth:api', 'auth-can:icommerce.options.edit'],
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.icommerce.options.delete',
        'uses' => 'OptionApiController@delete',
        'middleware' => ['auth:api', 'auth-can:icommerce.options.destroy'],
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.icommerce.options.show',
        'uses' => 'OptionApiController@show',
    ]);
});
