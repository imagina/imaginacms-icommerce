<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/wishlists'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.wishlists.create',
    'uses' => 'WishlistApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.wishlists.index',
    'uses' => 'WishlistApiController@index',
    'middleware' => ['auth:api']
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.wishlists.update',
    'uses' => 'WishlistApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.wishlists.delete',
    'uses' => 'WishlistApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.wishlists.show',
    'uses' => 'WishlistApiController@show',
    'middleware' => ['auth:api']
  ]);
  
});