<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/orderstatuses'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.orderstatuses.create',
    'uses' => 'OrderStatusApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.orderstatuses.index',
    'uses' => 'OrderStatusApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.orderstatuses.update',
    'uses' => 'OrderStatusApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.orderstatuses.delete',
    'uses' => 'OrderStatusApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.orderstatuses.show',
    'uses' => 'OrderStatusApiController@show',
  ]);
  
});