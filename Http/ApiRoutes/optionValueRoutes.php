<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/option-values'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.option-values.create',
    'uses' => 'OptionValueApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.option-values.index',
    'uses' => 'OptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.update',
    'uses' => 'OptionValueApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.delete',
    'uses' => 'OptionValueApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.option-values.show',
    'uses' => 'OptionValueApiController@show',
  ]);
  
});