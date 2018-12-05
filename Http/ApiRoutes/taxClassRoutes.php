<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/taxclasses'/*,'middleware' => ['auth:api']*/], function (Router $router) {
$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
$router->post('/', [
'as' => $locale . 'api.icommerce.taxclasses.create',
'uses' => 'TaxClassApiController@create',
]);
$router->get('/', [
'as' => $locale . 'api.icommerce.taxclasses.index',
'uses' => 'TaxClassApiController@index',
]);
$router->put('/{id}', [
'as' => $locale . 'api.icommerce.taxclasses.update',
'uses' => 'TaxClassApiController@update',
]);
$router->delete('/{id}', [
'as' => $locale . 'api.icommerce.taxclasses.delete',
'uses' => 'TaxClassApiController@delete',
]);
$router->get('/{criteria}', [
'as' => $locale . 'api.icommerce.taxclasses.show',
'uses' => 'TaxClassApiController@show',
]);

});