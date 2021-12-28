<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/tax-classes'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.tax-classes.create',
    'uses' => 'TaxClassApiController@create',
     'middleware' => ['auth:api','auth-can:icommerce.taxclasses.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.tax-classes.index',
    'uses' => 'TaxClassApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-classes.update',
    'uses' => 'TaxClassApiController@update',
     'middleware' => ['auth:api','auth-can:icommerce.taxclasses.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-classes.delete',
    'uses' => 'TaxClassApiController@delete',
     'middleware' => ['auth:api','auth-can:icommerce.taxclasses.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.tax-classes.show',
    'uses' => 'TaxClassApiController@show',
  ]);
  
});