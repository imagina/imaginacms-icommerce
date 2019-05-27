<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/categories'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.categories.create',
    'uses' => 'CategoryApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.categories.index',
    'uses' => 'CategoryApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.categories.update',
    'uses' => 'CategoryApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.categories.delete',
    'uses' => 'CategoryApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.categories.show',
    'uses' => 'CategoryApiController@show',
  ]);
  
});