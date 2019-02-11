<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/cart-products'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ? : \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.cart-products.create',
    'uses' => 'CartProductApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.cart-products.index',
    'uses' => 'CartProductApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.cart-products.update',
    'uses' => 'CartProductApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.cart-products.delete',
    'uses' => 'CartProductApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.cart-products.show',
    'uses' => 'CartProductApiController@show',
  ]);

});
