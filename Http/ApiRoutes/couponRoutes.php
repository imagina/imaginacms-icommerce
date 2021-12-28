<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/coupons'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->get('/coupons-validate', [
    'as' => $locale . 'api.icommerce.coupons.validate',
    'uses' => 'CouponApiController@validateCoupon',
    'middleware' => ['auth:api','auth-can:icommerce.coupons.manage']
  ]);
  $router->post('/', [
    'as' => $locale . 'api.icommerce.coupons.create',
    'uses' => 'CouponApiController@create',
    'middleware' => ['auth:api','auth-can:icommerce.coupons.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.coupons.index',
    'uses' => 'CouponApiController@index'
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.coupons.update',
    'uses' => 'CouponApiController@update',
    'middleware' => ['auth:api','auth-can:icommerce.coupons.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.coupons.delete',
    'uses' => 'CouponApiController@delete',
    'middleware' => ['auth:api','auth-can:icommerce.coupons.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.coupons.show',
    'uses' => 'CouponApiController@show',
  ]);


});
