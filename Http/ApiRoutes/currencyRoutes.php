<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/currencies'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.currencies.create',
    'uses' => 'CurrencyApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.currencies.index',
    'uses' => 'CurrencyApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.currencies.update',
    'uses' => 'CurrencyApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.currencies.delete',
    'uses' => 'CurrencyApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.currencies.show',
    'uses' => 'CurrencyApiController@show',
  ]);
  
});