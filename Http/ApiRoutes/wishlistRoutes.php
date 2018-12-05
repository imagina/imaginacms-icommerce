<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/wishlists'/*,'middleware' => ['auth:api']*/], function (Router $router) {
$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
$router->post('/', [
'as' => $locale . 'api.icommerce.wishlists.create',
'uses' => 'WishlistApiController@create',
]);
$router->get('/', [
'as' => $locale . 'api.icommerce.wishlists.index',
'uses' => 'WishlistApiController@index',
]);
$router->put('/{id}', [
'as' => $locale . 'api.icommerce.wishlists.update',
'uses' => 'WishlistApiController@update',
]);
$router->delete('/{id}', [
'as' => $locale . 'api.icommerce.wishlists.delete',
'uses' => 'WishlistApiController@delete',
]);
$router->get('/{criteria}', [
'as' => $locale . 'api.icommerce.wishlists.show',
'uses' => 'WishlistApiController@show',
]);

});