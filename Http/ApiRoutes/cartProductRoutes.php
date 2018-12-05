<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/cartproducts'/*,'middleware' => ['auth:api']*/], function (Router $router) {
$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
$router->post('/', [
'as' => $locale . 'api.icommerce.cartproducts.create',
'uses' => 'CartProductApiController@create',
]);
$router->get('/', [
'as' => $locale . 'api.icommerce.cartproducts.index',
'uses' => 'CartProductApiController@index',
]);
$router->put('/{id}', [
'as' => $locale . 'api.icommerce.cartproducts.update',
'uses' => 'CartProductApiController@update',
]);
$router->delete('/{id}', [
'as' => $locale . 'api.icommerce.cartproducts.delete',
'uses' => 'CartProductApiController@delete',
]);
$router->get('/{criteria}', [
'as' => $locale . 'api.icommerce.cartproducts.show',
'uses' => 'CartProductApiController@show',
]);

});