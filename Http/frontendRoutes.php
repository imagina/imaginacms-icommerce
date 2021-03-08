<?php

use Illuminate\Routing\Router;


$locale = LaravelLocalization::setLocale() ?: App::getLocale();
$customMiddlewares = config('asgard.icommerce.config.middlewares') ?? [];

  /** @var Router $router */
  Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => array_merge(['localize'], $customMiddlewares)], function (Router $router) use ($locale) {
    
    $router->get(trans('icommerce::routes.store.index.index'), [
      'as' => $locale . '.icommerce.store.index',
      'uses' => 'PublicController@index',
    ]);
    
    $router->get(trans('icommerce::routes.store.index.category'), [
      'as' => $locale . '.icommerce.store.index.category',
      'uses' => 'PublicController@index',
    ]);
    
    $router->get(trans('icommerce::routes.store.index.manufacturer'), [
      'as' => $locale . '.icommerce.store.index.manufacturer',
      'uses' => 'PublicController@indexManufacturer',
    ]);
    
    $router->get(trans('icommerce::routes.store.index.offers'), [
      'as' => $locale . '.icommerce.store.index.offers',
      'uses' => 'PublicController@indexOffers',
    ]);
    
    
    $router->get(trans('icommerce::routes.store.manufacturer.index'), [
      'as' => $locale . '.icommerce.store.manufacturer.index',
      'uses' => 'ManufacturerController@index',
    ]);
    
    $router->get(trans('icommerce::routes.store.index.categoryManufacturer'), [
      'as' => $locale . '.icommerce.store.index.categoryManufacturer',
      'uses' => 'PublicController@indexCategoryManufacturer',
    ]);
    
    $router->get(trans('icommerce::routes.store.show.product'), [
      'as' => $locale . '.icommerce.store.show',
      'uses' => 'PublicController@show',
    ]);
    
    $router->get(trans('icommerce::routes.store.checkout'), [
      'as' => $locale . '.icommerce.store.checkout',
      'uses' => 'PublicController@checkout',
      'middleware' => 'doNotCacheResponse'
    ]);
    
    $router->get(trans('icommerce::routes.store.order.index'), [
      'as' => $locale . '.icommerce.store.order.index',
      'uses' => 'OrderController@index',
      'middleware' => ['logged.in', 'doNotCacheResponse']
    ]);
    
    $router->get(trans('icommerce::routes.store.order.show'), [
      'as' => $locale . '.icommerce.store.order.show',
      'uses' => 'OrderController@show',
      'middleware' => 'doNotCacheResponse'
    ]);
    
  });


if(config('asgard.icommerce.config.useOldRoutes')){
  
  if (!App::runningInConsole()) {
    $categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $categories = $categoryRepository->getItemsBy(json_decode(json_encode(['fields' => 'id', 'include' => [], 'take' => null])));
    
    foreach ($categories as $category) {
      if(empty($category->slug)){
        continue;
      }
      /** @var Router $router */
      $router->group(['prefix' => $category->slug,
        'middleware' => $customMiddlewares], function (Router $router) use ($locale, $category) {
        
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
  
}



