<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/product-option-values'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.product-option-values.create',
    'uses' => 'ProductOptionValueApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.product-option-values.index',
    'uses' => 'ProductOptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.update',
    'uses' => 'ProductOptionValueApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.delete',
    'uses' => 'ProductOptionValueApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.product-option-values.show',
    'uses' => 'ProductOptionValueApiController@show',
  ]);
  
});