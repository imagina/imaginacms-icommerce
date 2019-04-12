# asgardcms-icommerce

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
##### Error Response
```
```

---

##### Get all orders
```GET``` ```/api/icommerce/v3/orders```
##### Success Response
``` 
All Orders with data
```
##### Error Response
```
```

---

##### Get an order (n = order_id)
```GET``` ```/api/icommerce/v3/orders/n```
##### Success Response
```
Order with data
```
##### Error Response
```
```

---

##### Update an order
```PUT``` ```/api/icommerce/v3/orders/n```
##### Success Response
```
Order updated
```
##### Error Response
```
```

---


---







# End Points Wishlists

##### Get all Wishlists
N: filter optional = 
```?filter={"user":1}```
```GET ``` ```/api/icommerce/v3/wishlists```
##### Create Wishlists
```POST``` ```/api/icommerce/v3/wishlists```
##### Update Wishlists
```PUT``` ```/api/icommerce/v3/wishlists/n```
##### Delete Wishlists
```DELETE``` ```/api/icommerce/v3/wishlists/n```

# End Points XXXXX

