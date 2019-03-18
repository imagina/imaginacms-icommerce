<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/orders'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.orders.create',
    'uses' => 'OrderApiController@create',
    //'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.orders.index',
    'uses' => 'OrderApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.update',
    'uses' => 'OrderApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.delete',
    'uses' => 'OrderApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.show',
    'uses' => 'OrderApiController@show',
  ]);
  
});