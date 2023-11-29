<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/option-values'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.option-values.create',
    'uses' => 'OptionValueApiController@create',
     'middleware' => ['auth:api','auth-can:icommerce.optionvalues.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.option-values.index',
    'uses' => 'OptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.update',
    'uses' => 'OptionValueApiController@update',
     'middleware' => ['auth:api','auth-can:icommerce.optionvalues.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.delete',
    'uses' => 'OptionValueApiController@delete',
     'middleware' => ['auth:api','auth-can:icommerce.optionvalues.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.show',
    'uses' => 'OptionValueApiController@show',
  ]);

  $router->post('/order', [
    'as' => $locale . 'api.icommerce.option-values.order',
    'uses' => 'OptionValueApiController@updateOrder',
    'middleware' => ['auth:api','auth-can:icommerce.optionvalues.edit']
  ]);
  
});