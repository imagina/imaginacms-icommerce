<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/tax-rates'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.tax-rates.create',
    'uses' => 'TaxRateApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.tax-rates.index',
    'uses' => 'TaxRateApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-rates.update',
    'uses' => 'TaxRateApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-rates.delete',
    'uses' => 'TaxRateApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-rates.show',
    'uses' => 'TaxRateApiController@show',
  ]);
  
});