# Asgardcms-icommerce

Icommerce is an e-commerce module for Asgard CMS open source fully customizable for entrepreneurs around the world. Go beyond the limits of traditional e-commerce solutions and be limited only by your own imagination.

## Installation

* `composer require imagina/icommerce-module`
* `php artisan module:migrate Icommerce`
* `php artisan module:migrate Icurrency`
* `php artisan module:seed Icommerce`
* `php artisan module:seed Icurrency`

## End Points

Route Base: `https://yourhost.com/api/icommerce/v3/`

* #### Stores

    * Attributes
    
        * name: string
        * address: string
        * phone: string
   
    * Create
    
        * Method: `POST`
        * URI: `/stores`
    
    * Read
    
         * Method: `GET`
         * URI: `/stores/:id`
         * URI: `/stores`
         
    * Update
    
         * Method: `PUT`
         * URI: `/stores/:id`
         
    * Delete
    
         * Method: `DELETE`
         * URI: `/stores/:id`

* #### Categories

    * Attributes
    
        * parent_id: Integer
        * options: Text
        * show_menu: Boolean
        * store_id: Integer
        * title: String (Translatable)
        * slug: String (Translatable)
        * description: Text (Translatable)
        * meta_title: Text (Translatable)
        * meta_description: Text (Translatable)
        * translatable_options: Text (Translatable)
    
    * Create
    * Read
    * Update
    * Delete
    
* #### Products

    * Attributes
    
        * added_by_id: Integer
        * options: String
        * status: String
        * category_id: Integer
        * parent_id: Integer
        * tax_class_id: Integer
        * sku: String
        * quantity: Integer
        * stock_status: String
        * manufacturer_id: Integer
        * shipping: String
        * price: Float
        * points: String
        * date_available: String
        * weight: String
        * length: String
        * width: String
        * height: String
        * subtract: String
        * minimum: String
        * reference: String
        * rating: String
        * freeshipping: String
        * order_weight: String
        * store_id: Integer
        * visible: String
        * sum_rating: String
        * name: String (Translatable)
        * description: String (Translatable)
        * summary: String (Translatable)
        * slug: String (Translatable)
        * meta_title: String (Translatable)
        * meta_description: String (Translatable)
    
    * Create
    
        * Method: `POST`
        * URI: `/products`
        
    * Read
    
        * Method: `GET`
        * URI: `/products`
    
    * Update
    
        * Method: `PUT`
        * URI: `/products`
        
    * Delete
    
        * Method: `DELETE`
        * URI: `/products`
    
* #### Carts

    * Attributes
    
         * user_id: Integer
         * ip: Ip
         * options: Text
         * status: String
         * store_id: Integer
    
    * Create
    
        * Method: `POST`
        * URI: `/carts`
            
    * Read
    
        * Method: `GET`
        * URI: `/carts`
            
    * Update
    
        * Method: `PUT`
        * URI: `/carts`
            
    * Delete
    
        * Method: `DELETE`
        * URI: `/carts`
    
* #### Cart Products

    * Attributes
    
        * cart_id: Integer
        * product_id: Integer
        * quantity: Integer
        * options: Text
    
    * Create
    
        * Method: `POST`
        * URI: `/cart-products`

    * Read
    
        * Method: `GET`
        * URI: `/cart-products`

    * Update
    
        * Method: `PUT`
        * URI: `/cart-products`

    * Delete
    
        * Method: `DELETE`
        * URI: `/cart-products`

    
* #### Coupons

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/coupons`

    * Read
    
        * Method: `GET`
        * URI: `/coupons`

    * Update
    
        * Method: `PUT`
        * URI: `/coupons`

    * Delete
    
        * Method: `DELETE`
        * URI: `/coupons`

* #### Manufacturers

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/manufacturers`

    * Read
    
        * Method: `GET`
        * URI: `/manufacturers`

    * Update
    
        * Method: `PUT`
        * URI: `/manufacturers`

    * Delete
    
        * Method: `DELETE`
        * URI: `/manufacturers`

* #### Options

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/options`

    * Read
    
        * Method: `GET`
        * URI: `/options`

    * Update
    
        * Method: `PUT`
        * URI: `/options`

    * Delete
    
        * Method: `DELETE`
        * URI: `/options`

* #### Option Values

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/option-values`

    * Read
    
        * Method: `GET`
        * URI: `/option-values`

    * Update
    
        * Method: `PUT`
        * URI: `/option-values`

    * Delete
    
        * Method: `DELETE`
        * URI: `/option-values`

* #### Orders

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/orders`

    * Read
    
        * Method: `GET`
        * URI: `/orders`

    * Update
    
        * Method: `PUT`
        * URI: `/orders`

    * Delete
    
        * Method: `DELETE`
        * URI: `/orders`

* #### Tax Class

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/tax-classes`

    * Read
    
        * Method: `GET`
        * URI: `/tax-classes`

    * Update
    
        * Method: `PUT`
        * URI: `/tax-classes`

    * Delete
    
        * Method: `DELETE`
        * URI: `/tax-classes`

* #### Tax Rates

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/tax-rates`

    * Read
    
        * Method: `GET`
        * URI: `/tax-rates`

    * Update
    
        * Method: `PUT`
        * URI: `/tax-rates`

    * Delete
    
        * Method: `DELETE`
        * URI: `/tax-rates`

* #### WishList

    * Attributes
    
    * Create
    
        * Method: `POST`
        * URI: `/wishlists`

    * Read
    
        * Method: `GET`
        * URI: `/wishlists`

    * Update
    
        * Method: `PUT`
        * URI: `/wishlists`

    * Delete
    
        * Method: `DELETE`
        * URI: `/wishlists`






* #### Shipping Methods

    * Attributes
    
    * Create
    * Read
    * Update
    * Delete
    
* #### Payment Methods

    * Attributes
    * Create
    * Read
    * Update
    * Delete









