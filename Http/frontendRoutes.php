<?php

use Illuminate\Routing\Router;


$categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
$categories = $categoryRepository->getItemsBy(json_decode(json_encode(['fields' => 'id', 'include' => [], 'take' => null])));
$locale = LaravelLocalization::setLocale() ?: App::getLocale();

foreach ($categories as $category) {
    /** @var Router $router */
    $router->group(['prefix' => $category->slug], function (Router $router) use ($locale, $category) {

        $router->get('/', [
            'as' => $locale . '.icommerce.category.' . $category->slug,
            'uses' => 'PublicController@index',
        ]);

        $router->get('{slug}', [
            'as' => $locale . '.icommerce.' . $category->slug . '.product',
            'uses' => 'PublicController@show',
        ]);
    });
}

/** @var Router $router */
$router->group(['prefix' => '/checkout'], function (Router $router) use ($locale) {


    $router->get('/', [
        'as' => $locale . 'icommerce.checkout',
        'uses' => 'PublicController@checkout',
    ]);

});

$router->group(['prefix' => '/orders'], function (Router $router) use ($locale) {

    $router->get('/', [
        'as' => $locale . '.icommerce.orders.index',
        'uses' => 'OrderController@index',
        'middleware' => 'logged.in'
    ]);
    $router->get('/email', [
        'as' => $locale . '.icommerce.orders.email',
        'uses' => 'OrderController@email',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}', [
        'as' => $locale . '.icommerce.orders.show',
        'uses' => 'OrderController@show',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}/{key}', [
        'as' => $locale . '.icommerce.order.showorder',
        'uses' => 'OrderController@show',
        'middleware' => 'auth.guest',
    ]);
});
