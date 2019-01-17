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

//======  TAGS
  require('ApiRoutes/tagRoutes.php');
  
  //======  PRODUCTS
  require('ApiRoutes/productRoutes.php');
  
  //======  PRODUCT OPTION VALUES
  require('ApiRoutes/productOptionValueRoutes.php');
  
  //======  ORDERS
  require('ApiRoutes/orderRoutes.php');
  
  //======  ORDER STATUS
  require('ApiRoutes/orderStatusRoutes.php');
  
  //======  ORDER STATUS HISTORY
  require('ApiRoutes/orderHistoryRoutes.php');
  
  //======  PRICE LISTS
  require('ApiRoutes/priceListRoutes.php');
  
  //======  PRODUCT LISTS
  require('ApiRoutes/productListRoutes.php');
  
  //======  PAYMENT METHODS
  require('ApiRoutes/paymentMethodRoutes.php');
  
  //======  TRANSACTION
  require('ApiRoutes/transactionRoutes.php');

  //======  SHIPPING METHODS
  require('ApiRoutes/shippingMethodRoutes.php');
  
});
