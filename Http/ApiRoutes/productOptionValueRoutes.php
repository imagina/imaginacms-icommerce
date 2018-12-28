<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/productoptionvalues'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.icommerce.productoptionvalues.create',
    'uses' => 'ProductOptionValueApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.productoptionvalues.index',
    'uses' => 'ProductOptionValueApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.productoptionvalues.update',
    'uses' => 'ProductOptionValueApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.productoptionvalues.delete',
    'uses' => 'ProductOptionValueApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.productoptionvalues.show',
    'uses' => 'ProductOptionValueApiController@show',
  ]);
  
});