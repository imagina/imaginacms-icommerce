<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/options'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.options.create',
    'uses' => 'OptionApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.options.index',
    'uses' => 'OptionApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.options.update',
    'uses' => 'OptionApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.options.delete',
    'uses' => 'OptionApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.options.show',
    'uses' => 'OptionApiController@show',
  ]);
});