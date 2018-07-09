<?php

use Illuminate\Routing\Router;

use Modules\Icommerce\Entities\Category as Category;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Manufacturer;


/** @var Router $router */
if (!App::runningInConsole()) {
  //dd(Category::all());
  $category = Category::where('slug', Request::path())->first();
  if (isset($category->slug) && !empty($category->slug)) {
    
    /** @var Router $router */
    $router->group(['prefix' => $category->slug], function (Router $router) use ($category) {
      $locale = LaravelLocalization::setLocale() ?: App::getLocale();
      
      $router->get('/', [
        'as' => $locale . '.icommerce.' . $category->slug,
        'uses' => 'PublicController@index',
      
      ]);//route /{category}/
      
    });//prefix category slug
  }
  
  //This is for sitemap
  foreach (Category::all() as $category) {
    $router->group(['prefix' => $category->slug], function (Router $router) use ($category) {
      $locale = LaravelLocalization::setLocale() ?: App::getLocale();
      
      $router->get('/', [
        'as' => $locale . '.icommerce.' . $category->slug,
        'uses' => 'PublicController@index',
      
      ]);//route /{category}/
      
    });//prefix category slug
  }
  //This is for sitemap
  
  
  /** @var Router $router */
  $router->group(['prefix' => 'bulkload'], function (Router $router) use ($category) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    
    $router->get('/', [
      'as' => 'bulk.load',
      'uses' => 'PublicController@bulk_load',
    ]);
  });
  
  
  /** @var Router $router */
  $router->group(['prefix' => 'search'], function (Router $router) use ($category) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    
    $router->get('/', [
      'as' => $locale . 'search',
      'uses' => 'PublicController@search',
    ]);
  });
  
  $router->group(['prefix' => 'categories'], function (Router $router) {
    
    $router->get('/', [
      'as' => 'icommerce.categories',
      'uses' => 'PublicController@categories',
    ]);
  });
  
  $product = Product::where('slug', Request::path())->first();
  if (isset($product->slug) && !empty($product->slug)) {
    
    $router->group(['prefix' => $product->slug], function (Router $router) use ($product) {
      
      $locale = LaravelLocalization::setLocale() ?: App::getLocale();
      
      $router->get('/', [
        'as' => $locale . '.icommerceslug.' . $product->slug,
        'uses' => 'PublicController@show',
      ]);
      
      
    });
    
  }
  //This is for sitemap
    foreach (Product::all() as $product) {
      $router->group(['prefix' => $product->slug], function (Router $router) use ($product) {

        $locale = LaravelLocalization::setLocale() ?: App::getLocale();

       $router->get('/', [
          'as' => $locale . '.icommerceslug.' . $product->slug,
         'uses' => 'PublicController@show',
       ]);//{product}/


     });//prefix $product->slug
    }
  //This is for sitemap
  
  /* Products freeshipping */
  $router->group(['prefix' => '/freeshipping'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    
    $router->get('/', [
      'as' => $locale . 'freeshipping',
      'uses' => 'PublicController@freeshipping',
    ]);
  });
  
  /*
  $manufacturer = Manufacturer::where('id', Request::path())->first();
  if (isset($manufacturer) && !empty($manufacturer)) {


    $router->group(['prefix' => '/brands/'.$manufacturer->id], function (Router $router) use ($manufacturer) {
      $locale = LaravelLocalization::setLocale() ?: App::getLocale();

      $router->get('/', [
        'as' => $locale . '.icommerce.' . $manufacturer->id,
        'uses' => 'PublicController@manufacturer',

      ]);//route /{category}/

    });//prefix category slug
  }
  */
}
/** @var Router $router */

$router->group(['prefix' => '/checkout'], function (Router $router) {
  
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
  $router->get('cart', [
    'as' => $locale . 'icommerce.cart',
    'uses' => 'PublicController@cart',
  ]);
  
  $router->post('/', [
    'as' => 'checkout.cart.store',
    'uses' => 'OrderController@store',
  ]);
  
  $router->get('/', [
    'as' => $locale . 'icommerce.checkout',
    'uses' => 'PublicController@checkout',
  ]);
  
  $router->post('login', [
    'as' => 'checkout.login',
    'uses' => 'AuthEcommerceController@postLogin'
  ]);
  
  $router->post('register', [
    'as' => 'checkout.register',
    'uses' => 'AuthEcommerceController@userRegister'
  ]);
  
  $router->get('logout', [
    'as' => 'checkout.logout',
    'uses' => 'AuthEcommerceController@getLogout'
  ]);
  
  
});

$router->group(['prefix' => trans('icommerce::manufacturers.uri')], function (Router $router) {
  
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
  $router->get('/', [
    'as' => $locale . 'icommerce.manufacturers',
    'uses' => 'ManufacturerController@index',
  ]);
  
  $router->get('/{id}', [
    'as' => $locale . 'icommerce.manufacturers.details',
    'uses' => 'ManufacturerController@show',
  ]);
});

$router->group(['prefix' => '/wishlist'], function (Router $router) {
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
  $router->get('/', [
    'as' => $locale . 'icommerce.wishlist',
    'uses' => 'PublicController@wishlist',
  ]);
});

$router->group(['prefix' => '/orders'], function (Router $router) {
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
  $router->get('/', [
    'as' => 'icommerce.orders.index',
    'uses' => 'OrderController@index',
    'middleware' => 'can:icommerce.orders.index'
  ]);
  $router->get('/email', [
    'as' => 'icommerce.orders.email',
    'uses' => 'OrderController@email',
  
  ]);
  $router->get('/{id}', [
    'as' => 'icommerce.orders.show',
    'uses' => 'OrderController@show',
    'middleware' => 'can:icommerce.orders.index',
  ]);
  $router->get('/{id}/{key}', [
    'as'=>'icommerce.order.showorder',
    'uses'=>'OrderController@show'
    
  ]);
});

$router->group(['prefix' => '/user'], function (Router $router) {
  
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
  
  $router->get('login', [
    'as' => $locale . 'icommerce.cart',
    'uses' => 'PublicController@getUserLogin',
  ]);
  
});
