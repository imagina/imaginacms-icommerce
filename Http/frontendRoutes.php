<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();
/** @var Router $router */

$router->get('{icommerceCategory}', [
    'as' => $locale . '.icommerce.category',
    'uses' => 'PublicController@index',
]);;

$router->get('{icommerceProduct}', [
    'as' => $locale . '.icommerceslug.product',
    'uses' => 'PublicController@show',
]);



/** @var Router $router */
$router->group(['prefix' => '/checkout'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/', [
        'as' => $locale . 'icommerce.checkout',
        'uses' => 'PublicController@checkout',
    ]);

});

$router->group(['prefix' => '/orders'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    $router->get('/', [
        'as' => $locale .'.icommerce.orders.index',
        'uses' => $locale .'.OrderController@index',
        'middleware' => 'logged.in'
    ]);
    $router->get('/email', [
        'as' => $locale .'.icommerce.orders.email',
        'uses' => 'OrderController@email',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}', [
        'as' => $locale .'.icommerce.orders.show',
        'uses' => 'OrderController@show',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}/{key}', [
        'as' => $locale .'.icommerce.order.showorder',
        'uses' => 'OrderController@show',
        'middleware' => 'auth.guest',
    ]);
});
