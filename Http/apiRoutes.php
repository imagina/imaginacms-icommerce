<?php

use Illuminate\Routing\Router;

$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
Route::prefix('/icommerce/v3')->group(function (Router $router) use($locale) {
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'categories',
    'controller' => 'CategoryApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.categories.create'],
      'index' => ['optional-auth'], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.categories.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.categories.destroy'],
      // 'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'manufacturers',
    'controller' => 'ManufacturerApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.manufacturers.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.manufacturers.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.manufacturers.destroy'],
      // 'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'tax-rates',
    'permission' => 'icommerce.taxrates',
    'controller' => 'TaxRateApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.taxrates.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.taxrates.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.taxrates.destroy'],
      //'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'tax-classes',
    'permission' => 'icommerce.taxclasses',
    'controller' => 'TaxClassApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.taxclasses.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.taxclasses.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.taxclasses.destroy'],
      // 'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'products',
    'controller' => 'ProductApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.products.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.products.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.products.destroy'],
      // 'restore' => [],
    ],
    'customRoutes' => [
      [
        'method' => 'post',
        'path' => '/rating/{criteria}',
        'as' =>'api.icommerce.products.rating',
        'uses' => 'rating',
        'middleware' => ['auth:api','auth-can:icommerce.products.rating']
      ],
      [
        'method' => 'post',
        'path' => '/sync/{criteria}',
        'as'=>'api.icommerce.products.sync',
        'uses' => 'syncProducts',
        'middleware'=>['auth:api']
      ]
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'options',
    'controller' => 'OptionApiController',
    'middleware' => [
      'create' => ['auth:api', 'auth-can:icommerce.options.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api', 'auth-can:icommerce.options.edit'],
      'delete' => ['auth:api', 'auth-can:icommerce.options.destroy'],
      'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'coupons',
    'controller' => 'CouponApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.coupons.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.coupons.edit'],
      'delete' => ['auth:api','auth-can:icommerce.coupons.destroy'],
      //'restore' => [],
    ],
    'customRoutes' => [
      [
        'method' => 'get',
        'path' => '/coupons-validate',
        'as' => $locale . 'api.icommerce.coupons.validate',
        'uses' => 'validateCoupon',
        'middleware' => ['auth:api','auth-can:icommerce.coupons.manage']
      ]
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'currencies',
    'controller' => 'CurrencyApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.currencies.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.currencies.edit'],
      'delete' => ['auth:api','auth-can:icommerce.currencies.destroy'],
      //'restore' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'order-statuses',
    'permission' => 'icommerce.orderstatuses',
    'controller' => 'OrderStatusApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.orderstatus.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.orderstatus.edit'],
      'delete' => ['auth:api','auth-can:icommerce.orderstatus.destroy'],
    //  'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'orders',
    'controller' => 'OrderApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.orders.create'],
      'index' => ['auth:api','auth-can:icommerce.orders.index'],
      'show' => ['auth:api','auth-can:icommerce.orders.edit'],
      'update' => ['auth:api','auth-can:icommerce.orders.edit'],
      'delete' => ['auth:api','auth-can:icommerce.orders.destroy'],
      //'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'option-values',
    'permission' => 'icommerce.optionvalues',
    'controller' => 'OptionValueApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.optionvalues.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.optionvalues.edit'],
      'delete' => ['auth:api','auth-can:icommerce.optionvalues.destroy'],
      //'restore' => [],
    ],
    'customRoutes' => [
      [
        'method' => 'post',
        'path' => '/order',
        'as' => $locale . 'api.icommerce.option-values.order',
        'uses' => 'updateOrder',
        'middleware' => ['auth:api','auth-can:icommerce.optionvalues.edit']
      ]
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'product-option',
    'permission' => 'icommerce.productoptions',
    'controller' => 'ProductOptionApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.productoptions.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.productoptions.edit'],
      'delete' => ['auth:api','auth-can:icommerce.productoptions.destroy'],
      //'restore' => [],
    ],
    'customRoutes' => [
      [
        'method' => 'post',
        'path' => '/order',
        'as' => 'api.icommerce.product-option.order',
        'uses' => 'updateOrder',
        'middleware' => ['auth:api','auth-can:icommerce.productoptions.edit']
      ]
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'product-discounts',
    'permission' => 'icommerce.productdiscounts',
    'controller' => 'ProductDiscountApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.productdiscounts.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.productdiscounts.edit'],
      'delete' => ['auth:api','auth-can:icommerce.productdiscounts.destroy'],
      //'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'item-types',
    'permission' => 'icommerce.itemtypes',
    'controller' => 'ItemTypeApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.itemtypes.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.itemtypes.edit'],
      'delete' => ['auth:api','auth-can:icommerce.itemtypes.destroy'],
      //'restore' => []
    ]
  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'orderitems',
//    'controller' => 'OrderItemApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'orderoptions',
//    'controller' => 'OrderOptionApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'order-status-history',
    'permission' => 'icommerce.orderstatushistories',
    'controller' => 'OrderStatusHistoryApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.orderhistories.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.orderhistories.edit'],
      'delete' => ['auth:api','auth-can:icommerce.orderhistories.destroy'],
      //'restore' => []
    ]
  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'couponorderhistories',
//    'controller' => 'CouponOrderHistoryApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'payment-methods',
    'controller' => 'PaymentMethodApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.payment-methods.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.payment-methods.edit'],
      'delete' => ['auth:api','auth-can:icommerce.payment-methods.destroy'],
      //'restore' => []
    ]
  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'transactions',
//    'controller' => 'TransactionApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'carts',
    'controller' => 'CartApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.cart.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.cart.edit'],
      'delete' => ['auth:api','auth-can:icommerce.cart.destroy'],
      //'restore' => []
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'cart-products',
    'controller' => 'CartProductApiController',
    'middleware' => [
      //'create' => [],
      'index' => [], 'show' => [],
      //'update' => [],
      //'delete' => [],
      //'restore' => []
    ]
  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'relatedproducts',
//    'controller' => 'RelatedProductApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'cartproductoptions',
//    'controller' => 'CartProductOptionApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'shipping-methods',
    'controller' => 'ShippingMethodApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.shipping-methods.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.shipping-methods.edit'],
      'delete' => ['auth:api','auth-can:icommerce.shipping-methods.destroy'],
      //'restore' => []
    ],
    'customRoutes' => [
      [
        'method' => 'get',
        'path' => '/calculations/all',
        'as' => $locale . 'api.icommerce.shipping-methods.calculations',
        'uses' => 'calculations'
      ]
    ]
  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'shippingmethodgeozones',
//    'controller' => 'ShippingMethodGeozoneApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'paymentmethodgeozones',
//    'controller' => 'PaymentMethodGeozoneApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'productables',
//    'controller' => 'ProductableApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
//  $router->apiCrud([
//    'module' => 'icommerce',
//    'prefix' => 'couponables',
//    'controller' => 'CouponableApiController',
//    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
//  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'weight-classes',
    'permission' => 'icommerce.weightclasses',
    'controller' => 'WeightClassApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.weightclasses.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.weightclasses.edit'],
      'delete' => ['auth:api','auth-can:icommerce.weightclasses.destroy'],
      'restore' => ['auth:api','auth-can:icommerce.weightclasses.restore']
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'length-classes',
    'permission' => 'icommerce.lengthclasses',
    'controller' => 'LengthClassApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.lengthclasses.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.lengthclasses.edit'],
      'delete' => ['auth:api','auth-can:icommerce.lengthclasses.destroy'],
      'restore' => ['auth:api','auth-can:icommerce.lengthclasses.restore']
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'volume-classes',
    'permission' => 'icommerce.volumeclasses',
    'controller' => 'VolumeClassApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.volumeclasses.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.volumeclasses.edit'],
      'delete' => ['auth:api','auth-can:icommerce.volumeclasses.destroy'],
      'restore' => ['auth:api','auth-can:icommerce.volumeclasses.restore']
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'quantity-classes',
    'permission' => 'icommerce.quantityclasses',
    'controller' => 'QuantityClassApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.quantityclasses.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.quantityclasses.edit'],
      'delete' => ['auth:api','auth-can:icommerce.quantityclasses.destroy'],
      'restore' => ['auth:api','auth-can:icommerce.quantityclasses.restore']
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'product-option-values',
    'permission' => 'icommerce.productoptionvalues',
    'controller' => 'ProductOptionValueApiController',
    'middleware' => [
      'create' => ['auth:api','auth-can:icommerce.productoptionvalues.create'],
      'index' => [], 'show' => [],
      'update' => ['auth:api','auth-can:icommerce.productoptionvalues.edit'],
      'delete' => ['auth:api','auth-can:icommerce.productoptionvalues.destroy'],
      //'restore' => []
    ]
  ]);
  //======  OPTION TYPES - STATIC
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'option-types',
    'permission' => 'icommerce.optiontypes',
    'staticEntity' => 'Modules\Icommerce\Entities\OptionType'
  ]);
    $router->apiCrud([
      'module' => 'icommerce',
      'prefix' => 'warehouses',
      'controller' => 'WarehouseApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
    $router->apiCrud([
      'module' => 'icommerce',
      'prefix' => 'product-warehouse',
      'permission' => 'icommerce.productwarehouses',
      'controller' => 'ProductWarehouseApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
    $router->apiCrud([
      'module' => 'icommerce',
      'prefix' => 'product-option-value-warehouse',
      'permission' => 'icommerce.productoptionvaluewarehouses',
      'controller' => 'ProductOptionValueWarehouseApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
      // 'customRoutes' => [ // Include custom routes if needed
      //  [
      //    'method' => 'post', // get,post,put....
      //    'path' => '/some-path', // Route Path
      //    'uses' => 'ControllerMethodName', //Name of the controller method to use
      //    'middleware' => [] // if not set up middleware, auth:api will be the default
      //  ]
      // ]
    ]);
// append





});
