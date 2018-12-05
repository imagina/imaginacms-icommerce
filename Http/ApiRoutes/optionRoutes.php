<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/options'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommerce.options.create',
    'uses' => 'OptionApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.options.index',
    'uses' => 'OptionApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.options.update',
    'uses' => 'OptionApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.options.delete',
    'uses' => 'OptionApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.options.show',
    'uses' => 'OptionApiController@show',
  ]);
  
});