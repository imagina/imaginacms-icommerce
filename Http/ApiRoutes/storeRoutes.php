<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/stores'/*,'middleware' => ['auth:api']*/], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale . 'api.icommerce.stores.create',
        'uses' => 'StoreApiController@create',
    ]);

    $router->get('/', [
        'as' => $locale . 'api.icommerce.stores.index',
        'uses' => 'StoreApiController@index',
    ]);

    $router->put('/{criteria}', [
        'as' => $locale . 'api.icommerce.stores.update',
        'uses' => 'StoreApiController@update',
    ]);

    $router->delete('/{criteria}', [
        'as' => $locale . 'api.icommerce.stores.delete',
        'uses' => 'StoreApiController@delete',
    ]);

    $router->get('/{criteria}', [
        'as' => $locale . 'api.icommerce.stores.show',
        'uses' => 'StoreApiController@show',
    ]);

});
