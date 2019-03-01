<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/mapareas'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale . 'api.icommerce.mapareas.create',
        'uses' => 'MapAreaApiController@create',
    ]);

    $router->get('/', [
        'as' => $locale . 'api.icommerce.mapareas.index',
        'uses' => 'MapAreaApiController@index',
    ]);

    $router->put('/{criteria}', [
        'as' => $locale . 'api.icommerce.mapareas.update',
        'uses' => 'MapAreaApiController@update',
    ]);

    $router->delete('/{criteria}', [
        'as' => $locale . 'api.icommerce.mapareas.delete',
        'uses' => 'MapAreaApiController@delete',
    ]);

    $router->get('/{criteria}', [
        'as' => $locale . 'api.icommerce.mapareas.show',
        'uses' => 'MapAreaApiController@show',
    ]);

});
