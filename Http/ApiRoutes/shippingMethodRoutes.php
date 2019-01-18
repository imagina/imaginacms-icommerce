<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/shipping-methods'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.shipping-methods.create',
    'uses' => 'ShippingMethodApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.shipping-methods.index',
    'uses' => 'ShippingMethodApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.shipping-methods.update',
    'uses' => 'ShippingMethodApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.shipping-methods.delete',
    'uses' => 'ShippingMethodApiController@delete',
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