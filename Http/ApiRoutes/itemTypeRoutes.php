<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/item-types'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.item-types.create',
    'uses' => 'ItemTypeApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.item-types.index',
    'uses' => 'ItemTypeApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.item-types.update',
    'uses' => 'ItemTypeApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.item-types.delete',
    'uses' => 'ItemTypeApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.item-types.show',
    'uses' => 'ItemTypeApiController@show',
  ]);
  
});