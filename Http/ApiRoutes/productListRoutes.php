<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/productlists'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommerce.productlists.create',
    'uses' => 'ProductListApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.productlists.index',
    'uses' => 'ProductListApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.productlists.update',
    'uses' => 'ProductListApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.productlists.delete',
    'uses' => 'ProductListApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.productlists.show',
    'uses' => 'ProductListApiController@show',
  ]);
  
});