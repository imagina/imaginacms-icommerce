<?php

use Illuminate\Routing\Router;

//TODO este grupo de rutas no se usa nunca desde front por ahora las dejo comentadas hasta el momento en que sean requeridas
//$router->group(['prefix' => '/transactions'/*,'middleware' => ['auth:api']*/], function (Router $router) {
//  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
//
//  $router->post('/', [
//    'as' => $locale . 'api.icommerce.transactions.create',
//    'uses' => 'TransactionApiController@create',
//     'middleware' => ['auth:api','can:icommerce.']
//  ]);
//  $router->get('/', [
//    'as' => $locale . 'api.icommerce.transactions.index',
//    'uses' => 'TransactionApiController@index',
//  ]);
//  $router->put('/{criteria}', [
//    'as' => $locale . 'api.icommerce.transactions.update',
//    'uses' => 'TransactionApiController@update',
//     'middleware' => ['auth:api','can:icommerce.']
//  ]);
//  $router->delete('/{criteria}', [
//    'as' => $locale . 'api.icommerce.transactions.delete',
//    'uses' => 'TransactionApiController@delete',
//     'middleware' => ['auth:api','can:icommerce.']
//  ]);
//  $router->get('/{criteria}', [
//    'as' => $locale . 'api.icommerce.transactions.show',
//    'uses' => 'TransactionApiController@show',
//  ]);
//
//});