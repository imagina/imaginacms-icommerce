<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/taxrates'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.taxrates.create',
    'uses' => 'TaxRateApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.taxrates.index',
    'uses' => 'TaxRateApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.taxrates.update',
    'uses' => 'TaxRateApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.taxrates.delete',
    'uses' => 'TaxRateApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.taxrates.show',
    'uses' => 'TaxRateApiController@show',
  ]);
  
});