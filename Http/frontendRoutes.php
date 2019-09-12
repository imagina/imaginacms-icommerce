<?php

use Illuminate\Routing\Router;
use Modules\Icommerce\Entities\CategoryTranslation as Category;
use Modules\Icommerce\Entities\ProductTranslation as Product;
/** @var Router $router */
if (!App::runningInConsole()) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    $uri=explode('/',Request::path());
    if($uri[0]===$locale){
        unset($uri[0]);
        $uri= implode('/', $uri);
    }else {
        $uri =implode('/',$uri);
    };

    $product = Product::where('slug', $uri)->first();
    if (isset($product->slug) && !empty($product->slug)) {
        $router->group(['prefix' => $product->slug], function (Router $router) use ($product , $locale) {
            $router->get('/', [
                'as' => $locale . '.icommerceslug.' . $product->slug,
                'uses' => 'PublicController@show',
            ]);
        });
    }

    $category = Category::where('slug', $uri)->first();
    if (isset($category->slug) && !empty($category->slug)) {
        $router->group(['prefix' => $category->slug], function (Router $router) use ($category , $locale) {
            $router->get('/', [
                'as' => $locale . '.icommerce.' . $category->slug,
                'uses' => 'PublicController@index',
            ]);
        });
    }

}
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
        'as' => 'icommerce.orders.index',
        'uses' => 'OrderController@index',
        'middleware' => 'logged.in'
    ]);
    $router->get('/email', [
        'as' => 'icommerce.orders.email',
        'uses' => 'OrderController@email',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}', [
        'as' => 'icommerce.orders.show',
        'uses' => 'OrderController@show',
        'middleware' => 'logged.in'
    ]);
    $router->get('/{id}/{key}', [
        'as' => 'icommerce.order.showorder',
        'uses' => 'OrderController@show',
        'middleware' => 'auth.guest',
    ]);
});
