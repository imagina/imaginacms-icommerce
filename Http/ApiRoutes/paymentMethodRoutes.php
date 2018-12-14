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
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.paymentmethods.update',
    'uses' => 'PaymentMethodApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.paymentmethods.delete',
    'uses' => 'PaymentMethodApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.paymentmethods.show',
    'uses' => 'PaymentMethodApiController@show',
  ]);
  
});