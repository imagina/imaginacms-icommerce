<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/tags'/*,'middleware' => ['auth:api']*/], function (Router $router) {
$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
$router->post('/', [
'as' => $locale . 'api.icommerce.tags.create',
'uses' => 'TagApiController@create',
]);
$router->get('/', [
'as' => $locale . 'api.icommerce.tags.index',
'uses' => 'TagApiController@index',
]);
$router->put('/{id}', [
'as' => $locale . 'api.icommerce.tags.update',
'uses' => 'TagApiController@update',
]);
$router->delete('/{id}', [
'as' => $locale . 'api.icommerce.tags.delete',
'uses' => 'TagApiController@delete',
]);
$router->get('/{criteria}', [
'as' => $locale . 'api.icommerce.tags.show',
'uses' => 'TagApiController@show',
]);

});