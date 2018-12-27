<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/pricelists'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.pricelists.create',
    'uses' => 'PriceListApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.pricelists.index',
    'uses' => 'PriceListApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.pricelists.update',
    'uses' => 'PriceListApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.pricelists.delete',
    'uses' => 'PriceListApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.pricelists.show',
    'uses' => 'PriceListApiController@show',
  ]);
  
});