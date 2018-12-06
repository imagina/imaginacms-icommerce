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

//======  TAGS
  require('ApiRoutes/tagRoutes.php');
  
});
