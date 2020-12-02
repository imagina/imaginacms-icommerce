# Icommerce Imagina 
Icommerce is an e-commerce module for Asgard CMS open source fully customizable for entrepreneurs around the world. Go beyond the limits of traditional e-commerce solutions and be limited only by your own imagination.

### Email Configurations Backend

	1. Go to Settings
	2. Click on Icommerce
	3. Add "Webmaster Email"

### Email Configurations Frontend (Theme)

	You can modify the header,footer and style

	Instructions: 

		1. Create a folder in your theme with the name "icommerce". 
            Example: YourTheme/views/icommerce/

		2. Create a folder inside of "icommerce" with the name "emails". 
            Example: YourTheme/views/icommerce/emails

		3. If you want just edit the header, so copy only the header file
        from the module in your folder in the theme: 
			
			(copy this file)
			Example: Module/Icommerce/Resources/views/emails/base/header.blade.php 
			
			(Paste it here)
			Example: YourTheme/views/icommerce/emails/header.blade.php

        and so with the files that you want to edit.

## Seeder

    run php artisan module:seed Icommerce
    

## API


[![](https://www.imaginacolombia.com/themes/imagina2017/img/logo.png)](https://www.imaginacolombia.com/)

# End Points Cart

### Get all carts
N: filter optional = 
```?filter={"ip":192.168.0.1}```
```?filter={"user":1}```
```
GET: /api/icommerce/v3/carts
```

### Get a cart
N: replace n for id`s cart 
```
GET: /api/icommerce/v3/carts/n
```

### Get all the products of all the cars
N: filter optional = ```?filter={"cart":2}```
```
GET: /api/icommerce/v3/cart-products
```

### Add products to cart
```POST``` ```/api/icommerce/v3/carts```

```{
  "cart_id": 9, (optional, if it is not passed a new car is generated and its id is returned)
  "user_id": 1, (optional, if it is not passed, the car is generated without associating a user)
  "cart_products": {
    "product_id":"4",
    "quantity":"50",
     "price":"5500"
    },
  "cart_product_option":{
    "product_option_id":"1",
    "product_option_value_id":"1"
  }
}
```


# End Points Order 

##### Create order
```POST``` ```/api/icommerce/v3/orders```
##### Success Response
``` 
Order created
```


##### Get all orders
```GET``` ```/api/icommerce/v3/orders```
##### Success Response
``` 
All Orders with data
```


##### Get an order (n = order_id)
```GET``` ```/api/icommerce/v3/orders/n```
##### Success Response
```
Order with data
```

##### Update an order
```PUT``` ```/api/icommerce/v3/orders/n```
##### Success Response
```
Order updated
```








# End Points Wishlists

##### Get all Wishlists
```GET ``` ```/api/icommerce/v3/wishlists```
N: filter optional = ```?filter={"user":1}```
##### Get a Wishlist
```GET``` ```/api/icommerce/v3/wishlists/n```
##### Create Wishlist (all data inside "attribute" array)
```POST``` ```/api/icommerce/v3/wishlists```
##### Update Wishlist
```PUT``` ```/api/icommerce/v3/wishlists/n```
##### Delete Wishlist
```DELETE``` ```/api/icommerce/v3/wishlists/n```

# End Points Tags

##### Get all Tags
```GET ``` ```/api/icommerce/v3/tags```
##### Get a Tag 
```GET``` ```/api/icommerce/v3/tags/n```
##### Create Tag (all data inside "attribute" array)
```POST``` ```/api/icommerce/v3/tags```
##### Update Tag
```PUT``` ```/api/icommerce/v3/tags/n```
##### Delete Tag
```DELETE``` ```/api/icommerce/v3/tags/n```

# End Points Categories

##### Get all Categories
```GET ``` ```/api/icommerce/v3/categories```
N: include optional = 
```?include=parent,children```

##### Get a Category
```GET``` ```/api/icommerce/v3/categories/n```
##### Create Category (all data inside "attribute" array)
```POST``` ```/api/icommerce/v3/categories```
##### Update Category
```PUT``` ```/api/icommerce/v3/categories/n```
##### Delete Category
```DELETE``` ```/api/icommerce/v3/categories/n```

# End Points Currencies

##### Get all Currencies
```GET ``` ```/api/icommerce/v3/currencies```
##### Get a Currency
```GET``` ```/api/icommerce/v3/currencies/n```
##### Create Currency (all data inside "attribute" array)
```POST``` ```/api/icommerce/v3/currencies```
##### Update Currency
```PUT``` ```/api/icommerce/v3/currency/n```
##### Delete Currency
```DELETE``` ```/api/icommerce/v3/currency/n```


# End Points Payment Methods

##### Get all Payment Methods
```GET ``` ```/api/icommerce/v3/payment-methods```
##### Get a Payment Method
```GET``` ```/api/icommerce/v3/payment-methods/n```
##### Create Payment Method
All payment methods have a Seeder to create
##### Update Payment Method
```PUT``` ```/api/icommerce/v3/payment-methods/n```

# End Points Shipping Methods

##### Get all Shipping Methods
```GET ``` ```/api/icommerce/v3/shipping-methods```
##### Get a Shipping Method
```GET``` ```/api/icommerce/v3/shipping-methods/n```
##### Get all Calculations from Shipping Methods

Parameters
  - Options (array) - countryCode,country,zone,postalCode ... anything else
  - Products (array) - cart_id

```GET ``` ```/api/icommerce/v3/shipping-methods/calculations/all```

##### Create Shipping Method
All shipping methods have a Seeder to create
##### Update Shipping Method
```PUT``` ```/api/icommerce/v3/shipping-methods/n```

#### Coupons
##### Get discount of the coupon in cart

This route require authentication 

Request:

```GET``` ```/api/icommerce/v3/coupons/coupons-validate```

```js
filter = {
  "couponCode":"code_coupon",
  "cartId":1
}
```

Response:

```js
{
    "message": "coupon whit discount for product",
    "discount": 3000
}
```
| MESSAGE  | |
| ------------- | ------------- |
| coupon not exists  |   |
| coupon inactive  |   |
| coupon no started  |   |
| coupon expired  |   |
| maximum used coupons  |   |
| maximum coupons per user used  |  |
| cart not exists  | |
| cart without items  |  |
| coupon whit discount for order  |  |
| coupon whit discount for product  |  |
| coupon whit discount for category  |  |





# End Points XXXXX

