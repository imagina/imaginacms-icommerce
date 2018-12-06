<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/orderstatushistory'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommerce.orderstatushistory.create',
    'uses' => 'OrderStatusHistoryApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.orderstatushistory.index',
    'uses' => 'OrderStatusHistoryApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.orderstatushistory.update',
    'uses' => 'OrderStatusHistoryApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.orderstatushistory.delete',
    'uses' => 'OrderStatusHistoryApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.orderstatushistory.show',
    'uses' => 'OrderStatusHistoryApiController@show',
  ]);
  
});