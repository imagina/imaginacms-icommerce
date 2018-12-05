<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/coupons'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  $router->post('/', [
    'as' => $locale . 'api.icommerce.coupons.create',
    'uses' => 'CouponApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.coupons.index',
    'uses' => 'CouponApiController@index',
  ]);
  $router->put('/{id}', [
    'as' => $locale . 'api.icommerce.coupons.update',
    'uses' => 'CouponApiController@update',
  ]);
  $router->delete('/{id}', [
    'as' => $locale . 'api.icommerce.coupons.delete',
    'uses' => 'CouponApiController@delete',
  ]);
  $router->get('/{id}', [
    'as' => $locale . 'api.icommerce.coupons.show',
    'uses' => 'CouponApiController@show',
  ]);
  
});