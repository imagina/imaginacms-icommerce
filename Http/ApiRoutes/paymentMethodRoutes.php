<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/payment-methods'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.payment-methods.create',
    'uses' => 'PaymentMethodApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.payment-methods.index',
    'uses' => 'PaymentMethodApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.payment-methods.update',
    'uses' => 'PaymentMethodApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.payment-methods.delete',
    'uses' => 'PaymentMethodApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.payment-methods.show',
    'uses' => 'PaymentMethodApiController@show',
  ]);
  
});