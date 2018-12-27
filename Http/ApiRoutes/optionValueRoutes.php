<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/optionvalues'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.optionvalues.create',
    'uses' => 'OptionValueApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.optionvalues.index',
    'uses' => 'OptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.optionvalues.update',
    'uses' => 'OptionValueApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.optionvalues.delete',
    'uses' => 'OptionValueApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.optionvalues.show',
    'uses' => 'OptionValueApiController@show',
  ]);
  
});