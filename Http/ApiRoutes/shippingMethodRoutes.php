<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/shipping-methods'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.shipping-methods.create',
    'uses' => 'ShippingMethodApiController@create',
    'middleware' => ['auth:api','auth-can:icommerce.shipping-methods.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.shipping-methods.index',
    'uses' => 'ShippingMethodApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.shipping-methods.update',
    'uses' => 'ShippingMethodApiController@update',
    'middleware' => ['auth:api','auth-can:icommerce.shipping-methods.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.shipping-methods.delete',
    'uses' => 'ShippingMethodApiController@delete',
    'middleware' => ['auth:api','auth-can:icommerce.shipping-methods.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.shipping-methods.show',
    'uses' => 'ShippingMethodApiController@show',
  ]);

  $router->get('/calculations/all', [
    'as' => $locale . 'api.icommerce.shipping-methods.calculations',
    'uses' => 'ShippingMethodApiController@calculations',
  ]);
  
});