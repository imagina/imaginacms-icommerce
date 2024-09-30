<?php

use Illuminate\Routing\Router;
$locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
$router->group(['prefix' => '/icommerce/v3'], function (Router $router) use($locale){
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'categories',
    'permission' => 'icommerce.categories',
    'controller' => 'CategoryApiController',
    'middleware' => [
      'index' => ['optional-auth'], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'manufacturers',
    'permission' => 'icommerce.manufacturers',
    'controller' => 'ManufacturerApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'tax-rates',
    'permission' => 'icommerce.taxrates',
    'controller' => 'TaxRateApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'tax-classes',
    'permission' => 'icommerce.taxclasses',
    'controller' => 'TaxClassApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'products',
    'permission' => 'icommerce.products',
    'controller' => 'ProductApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
    'permission' => 'icommerce.options',
    'controller' => 'OptionApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'coupons',
    'permission' => 'icommerce.coupons',
    'controller' => 'CouponApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
    'permission' => 'icommerce.currencies',
    'controller' => 'CurrencyApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'order-statuses',
    'permission' => 'icommerce.orderstatuses',
    'controller' => 'OrderStatusApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'orders',
    'permission' => 'icommerce.orders',
    'controller' => 'OrderApiController',
    'middleware' => [
      'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'option-values',
    'permission' => 'icommerce.optionvalues',
    'controller' => 'OptionValueApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
      'index' => [], 'show' => [],
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
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'item-types',
    'permission' => 'icommerce.itemtypes',
    'controller' => 'ItemTypeApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
      'index' => [], 'show' => [],
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
    'permission' => 'icommerce.payment-methods',
    'controller' => 'PaymentMethodApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
    'permission' => 'icommerce.carts',
    'controller' => 'CartApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'cart-products',
    'permission' => 'icommerce.cartproducts',
    'controller' => 'CartProductApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
    'permission' => 'icommerce.shipping-methods',
    'controller' => 'ShippingMethodApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'length-classes',
    'permission' => 'icommerce.lengthclasses',
    'controller' => 'LengthClassApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'volume-classes',
    'permission' => 'icommerce.volumeclasses',
    'controller' => 'VolumeClassApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'quantity-classes',
    'permission' => 'icommerce.quantityclasses',
    'controller' => 'QuantityClassApiController',
    'middleware' => [
      'index' => [], 'show' => [],
    ]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'product-option-values',
    'permission' => 'icommerce.productoptionvalues',
    'controller' => 'ProductOptionValueApiController',
    'middleware' => [
      'index' => [], 'show' => [],
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
      'permission' => 'icommerce.warehouses',
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
