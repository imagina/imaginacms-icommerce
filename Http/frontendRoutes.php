<?php

use Illuminate\Routing\Router;


$locale = LaravelLocalization::setLocale() ?: App::getLocale();

if (!App::runningInConsole()) {
    $categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $categories = $categoryRepository->getItemsBy(json_decode(json_encode(['fields' => 'id', 'include' => [], 'take' => null])));
    foreach ($categories as $category) {
        /** @var Router $router */
        $router->group(['prefix' => $category->slug], function (Router $router) use ($locale, $category) {

            $router->get('/', [
                'as' => $locale . '.icommerce.category.' . $category->slug,
                'uses' => 'OldPublicController@index',
            ]);

            $router->get('{slug}', [
                'as' => $locale . '.icommerce.' . $category->slug . '.product',
                'uses' => 'OldPublicController@show',
            ]);
        });
    }
}

$router->get('/wishlist', [
  'as' => 'icommerce.wishlists.index',
  'uses' => 'OldPublicController@wishlist',
  'middleware' => 'logged.in'
]);


/** @var Router $router */
Route::group(['prefix' => LaravelLocalization::setLocale(),
  'middleware' => ['localize']], function (Router $router) use ($locale) {
  
  $router->get(trans('icommerce::routes.store.index'), [
    'as' => $locale . '.icommerce.store.index',
    'uses' => 'PublicController@index',
  ]);
  
  $router->get(trans('icommerce::routes.store.category'), [
    'as' => $locale . '.icommerce.store.index.category',
    'uses' => 'PublicController@index',
  ]);
  
  $router->get(trans('icommerce::routes.store.product'), [
    'as' => $locale . '.icommerce.store.show',
    'uses' => 'PublicController@show',
  ]);
  
  $router->get(trans('icommerce::routes.store.wishlist'), [
    'as' =>  $locale . '.icommerce.store.wishlists.index',
    'uses' => 'PublicController@wishlist',
    'middleware' => 'logged.in'
  ]);
  
  $router->get(trans('icommerce::routes.store.checkout'), [
    'as' => $locale . '.icommerce.store.checkout',
    'uses' => 'PublicController@checkout',
  ]);
  
  $router->get(trans('icommerce::routes.store.order.index'), [
    'as' => $locale . '.icommerce.store.order.index',
    'uses' => 'OrderController@index',
    'middleware' => 'logged.in'
  ]);

  $router->get(trans('icommerce::routes.store.order.show'), [
    'as' => $locale . '.icommerce.store.order.show',
    'uses' => 'OrderController@show',
    'middleware' => 'logged.in'
  ]);
  
});


/** @var Router $router */
$router->group(['prefix' => 'store/search'], function (Router $router) use ($locale) {
  
  $router->get('/', [
    'as' => $locale . 'icommerce.search',
    'uses' => 'OldPublicController@search',
  ]);
  
});

/** @var Router $router */
$router->group(['prefix' => '/checkout'], function (Router $router) use ($locale) {


    $router->get('/', [
        'as' => $locale . 'icommerce.checkout',
        'uses' => 'OldPublicController@checkout',
    ]);

});

$router->group(['prefix' => '/orders'], function (Router $router) use ($locale) {

    $router->get('/', [
        'as' => $locale . '.icommerce.orders.index',
        'uses' => 'OldOrderController@index',
        'middleware' => 'logged.in'
    ]);
    $router->get('/email', [
        'as' => $locale . '.icommerce.orders.email',
        'uses' => 'OldOrderController@email',
        'middleware' => 'logged.in'
    ]);
  
    $router->get('/{id}', [
        'as' => $locale . '.icommerce.orders.show',
        'uses' => 'OldOrderController@show',
        'middleware' => 'logged.in'
    ]);
    
    /*
    $router->get('/{id}/{key}', [
        'as' => $locale . '.icommerce.order.showorder',
        'uses' => 'OldOrderController@show',
        'middleware' => 'logged.in',
    ]);
    */
});
