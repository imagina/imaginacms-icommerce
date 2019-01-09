<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/transactions'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.transactions.create',
    'uses' => 'TransactionApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.transactions.index',
    'uses' => 'TransactionApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.transactions.update',
    'uses' => 'TransactionApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.transactions.delete',
    'uses' => 'TransactionApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.transactions.show',
    'uses' => 'TransactionApiController@show',
  ]);
  
});