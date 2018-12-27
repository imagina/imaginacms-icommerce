<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/paymentmethods'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.paymentmethods.create',
    'uses' => 'PaymentMethodApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.paymentmethods.index',
    'uses' => 'PaymentMethodApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.paymentmethods.update',
    'uses' => 'PaymentMethodApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.paymentmethods.delete',
    'uses' => 'PaymentMethodApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.paymentmethods.show',
    'uses' => 'PaymentMethodApiController@show',
  ]);
  
});