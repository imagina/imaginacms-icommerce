<?php

use Illuminate\Routing\Router;

$locale = locale();
$customMiddlewares = config('asgard.icommerce.config.middlewares') ?? [];

/** @var Router $router */
Route::middleware(array_merge(['localize'], $customMiddlewares))->group(function (Router $router) use ($locale) {
    $router->get(trans('icommerce::routes.store.index.index', [], $locale), [
        'as' => $locale.'.icommerce.store.index',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('icommerce::routes.store.index.category', [], $locale), [
        'as' => $locale.'.icommerce.store.index.category',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('icommerce::routes.store.index.manufacturer', [], $locale), [
        'as' => $locale.'.icommerce.store.index.manufacturer',
        'uses' => 'PublicController@indexManufacturer',
    ]);

    $router->get(trans('icommerce::routes.store.index.offers', [], $locale), [
        'as' => $locale.'.icommerce.store.index.offers',
        'uses' => 'PublicController@indexOffers',
    ]);

    $router->get(trans('icommerce::routes.store.index.featured',[],$locale), [
      'as' => $locale . '.icommerce.store.index.featured',
      'uses' => 'PublicController@indexFeatured',
    ]);
    
    
    $router->get(trans('icommerce::routes.store.manufacturer.index', [], $locale), [
        'as' => $locale.'.icommerce.store.manufacturer.index',
        'uses' => 'ManufacturerController@index',
    ]);

    $router->get(trans('icommerce::routes.store.index.categoryManufacturer', [], $locale), [
        'as' => $locale.'.icommerce.store.index.categoryManufacturer',
        'uses' => 'PublicController@indexCategoryManufacturer',
    ]);

    $router->get(trans('icommerce::routes.store.show.product', [], $locale), [
        'as' => $locale.'.icommerce.store.show',
        'uses' => 'PublicController@show',
        'middleware' => ['doNotCacheResponse'],
    ]);

    $router->get(trans('icommerce::routes.store.checkout.create', [], $locale), [
        'as' => $locale.'.icommerce.store.checkout',
        'uses' => 'PublicController@checkout',
        'middleware' => ['doNotCacheResponse'],
    ]);

    $router->get(trans('icommerce::routes.store.checkout.update', [], $locale), [
        'as' => $locale.'.icommerce.store.checkout.update',
        'uses' => 'PublicController@checkoutUpdate',
        'middleware' => 'doNotCacheResponse',
    ]);

    $router->get(trans('icommerce::routes.store.order.index', [], $locale), [
        'as' => $locale.'.icommerce.store.order.index',
        'uses' => 'OrderController@index',
        'middleware' => ['logged.in', 'doNotCacheResponse'],
    ]);

    $router->get(trans('icommerce::routes.store.order.show', [], $locale), [
        'as' => $locale.'.icommerce.store.order.show',
        'uses' => 'OrderController@show',
        'middleware' => 'doNotCacheResponse',
    ]);
});

if (config('asgard.icommerce.config.useOldRoutes')) {
    if (! App::runningInConsole()) {
        $categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
        $categories = $categoryRepository->getItemsBy(json_decode(json_encode(['fields' => 'id', 'include' => [], 'take' => null])));

        foreach ($categories as $category) {
            if (empty($category->slug)) {
                continue;
            }
            /** @var Router $router */
            Route::prefix($category->slug)->middleware($customMiddlewares)->group(function (Router $router) use ($locale, $category) {
                $router->get('/', [
                    'as' => $locale.'.icommerce.category.'.$category->slug,
                    'uses' => 'OldPublicController@index',
                ]);

                $router->get('{slug}', [
                    'as' => $locale.'.icommerce.'.$category->slug.'.product',
                    'uses' => 'OldPublicController@show',
                ]);
            });
        }
    }
}
