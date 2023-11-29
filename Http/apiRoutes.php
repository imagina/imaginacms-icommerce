<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/icommerce/v3'/*,'middleware' => ['auth:api']*/], function (Router $router) {
//======  CATEGORIES
  require('ApiRoutes/categoryRoutes.php');

//======  COUPONS
  require('ApiRoutes/couponRoutes.php');

//======  CURRENCIES
  require('ApiRoutes/currencyRoutes.php');

//======  MANUFACTURERS
  require('ApiRoutes/manufacturerRoutes.php');

//======  OPTIONS
  require('ApiRoutes/optionRoutes.php');

//======  OPTIONS VALUES
  require('ApiRoutes/optionValueRoutes.php');

//======  CARTS
  require('ApiRoutes/cartRoutes.php');

//======  CART PRODUCTS
  require('ApiRoutes/cartProductRoutes.php');

//======  TAX CLASSES
  require('ApiRoutes/taxClassRoutes.php');

  //======  TAX RATES
  require('ApiRoutes/taxRateRoutes.php');


  //======  PRODUCTS
  require('ApiRoutes/productRoutes.php');

  //======  PRODUCTS-OPTIONS
  require('ApiRoutes/productOptionRoutes.php');

  //======  PRODUCT OPTION VALUES
  require('ApiRoutes/productOptionValueRoutes.php');

  //======  PRODUCT DISCOUNTS
  require('ApiRoutes/productDiscountRoutes.php');

  //======  ORDERS
  require('ApiRoutes/orderRoutes.php');

  //======  ORDER STATUS
  require('ApiRoutes/orderStatusRoutes.php');

  //======  ORDER STATUS HISTORY
  require('ApiRoutes/orderHistoryRoutes.php');


  //======  PAYMENT METHODS
  require('ApiRoutes/paymentMethodRoutes.php');

  //======  TRANSACTION
  require('ApiRoutes/transactionRoutes.php');

  //======  SHIPPING METHODS
  require('ApiRoutes/shippingMethodRoutes.php');

  //======  STORES
  require('ApiRoutes/storeRoutes.php');

  //======  ITEM TYPES
  require('ApiRoutes/itemTypeRoutes.php');


  //======  OPTION TYPES - STATIC
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'option-types',
    'staticEntity' => 'Modules\Icommerce\Entities\OptionType'
  ]);
  
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'weight-classes',
    'controller' => 'WeightClassApiController',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
  $router->apiCrud([
    'module' => 'icommerce',
    'prefix' => 'length-classes',
    'controller' => 'LengthClassApiController',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
    $router->apiCrud([
      'module' => 'icommerce',
      'prefix' => 'volume-classes',
      'controller' => 'VolumeClassApiController',
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
      'prefix' => 'quantity-classes',
      'controller' => 'QuantityClassApiController',
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
