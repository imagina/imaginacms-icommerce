<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-option-values'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.product-option-values.create',
    'uses' => 'ProductOptionValueApiController@create',
     'middleware' => ['auth:api','auth-can:icommerce.productoptionvalues.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.product-option-values.index',
    'uses' => 'ProductOptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.update',
    'uses' => 'ProductOptionValueApiController@update',
     'middleware' => ['auth:api','auth-can:icommerce.productoptionvalues.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.delete',
    'uses' => 'ProductOptionValueApiController@delete',
     'middleware' => ['auth:api','auth-can:icommerce.productoptionvalues.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.show',
    'uses' => 'ProductOptionValueApiController@show',
  ]);
  
});