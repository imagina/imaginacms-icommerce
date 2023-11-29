<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/carts'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.carts.create',
    'uses' => 'CartApiController@create',
     'middleware' => ['auth:api','auth-can:icommerce.cart.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.carts.index',
    'uses' => 'CartApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.carts.update',
    'uses' => 'CartApiController@update',
     'middleware' => ['auth:api','auth-can:icommerce.cart.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.carts.delete',
    'uses' => 'CartApiController@delete',
     'middleware' => ['auth:api','auth-can:icommerce.cart.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.carts.show',
    'uses' => 'CartApiController@show',
  ]);
  
});