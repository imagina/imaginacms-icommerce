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

//======  WISHLISTS
  require('ApiRoutes/wishlistRoutes.php');

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


});
