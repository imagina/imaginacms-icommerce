<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/orders'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommerce.orders.create',
    'uses' => 'OrderApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.orders.index',
    'uses' => 'OrderApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.orders.update',
    'uses' => 'OrderApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.orders.delete',
    'uses' => 'OrderApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.orders.show',
    'uses' => 'OrderApiController@show',
  ]);
  
});