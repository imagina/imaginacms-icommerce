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
    
        * Method: `POST`
        * URI: `/categories`
    
    * Read
    
         * Method: `GET`
         * URI: `/stores/:id`
         * URI: `/categories`
         
    * Update
    
         * Method: `PUT`
         * URI: `/categories/:id`
         
    * Delete
    
         * Method: `DELETE`
         * URI: `/categories/:id`
    
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
    
        * code: String
        * type: String
        * category_id: Integer
        * product_id: Integer
        * customer_id: Integer
        * store_id: Integer
        * discount: Float
        * type_discount: String
        * logged: String
        * shipping: String
        * date_start: Date
        * date_end: Date
        * quantity_total: Integer
        * quantity_total_customer: Integer
        * status: String
        * options: Text
        * minimum_amount: Integer
        * minimum_quantity_products: Integer
    
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
    
        * active: String
        * options: String
        * store_id: Integer
        * name: String (Translatable)
        * slug: String (Translatable)
        * description: String (Translatable)
        * translatable_options: String (Translatable)
    
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
    
        * type: String
        * sort_order: String
        * options: Text
        * description: Text (Translate)
    
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
    
        * option_id: Integer
        * sort_order: Integer
        * options: String
        * description: String (Translatable)
    
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
    
         * invoice_nro: Integer
         * invoice_prefix: String
         * total: String
         * status_id: Integer
         * customer_id: Integer
         * added_by_id: Integer
         * first_name: String
         * last_name: String
         * email: String
         * telephone: String
         * payment_first_name: String
         * payment_last_name: String
         * payment_company: String
         * payment_nit: String
         * payment_email: String
         * payment_address_1: String
         * payment_address_2: String
         * payment_city: String
         * payment_zip_code: String
         * payment_country: String
         * payment_zone: String
         * payment_address_format: String
         * payment_custom_field: String
         * payment_method: String
         * payment_code: String
         * payment_name: String
         * shipping_first_name: String
         * shipping_last_name: String
         * shipping_company: String
         * shipping_address_1: String
         * shipping_address_2: String
         * shipping_city: String
         * shipping_zip_code: String
         * shipping_country_code: String
         * shipping_zone: String
         * shipping_address_format: String
         * shipping_custom_field: String
         * shipping_method: String
         * shipping_code: String
         * shipping_amount: String
         * store_id: Integer
         * store_name: String
         * store_address: String
         * store_phone: String
         * tax_amount: String
         * comment: String
         * tracking: String
         * currency_id: Integer
         * currency_code: Integer
         * currency_value: Integer
         * ip: Ip
         * user_agent: Integer
         * key: String
         * options: Text
    
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
    
        * name: String
        * description: Text
    
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
    
         * rate: String
         * type: String
         * geozone_id: Integer
         * customer: String
         * tax_class_id: Integer
         * store_id: Integer
         * name: String (Translatable)
    
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
    
         * user_id: Integer
         * product_id: Integer
         * store_id: Integer
         * options: Text
    
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
    
        * active: String
        * name: String
        * options: String
        * store_id: Integer
        * title: String (Translatable)
        * description: String (Translatable)
    
    * Create
    
        * Method: `POST`
        * URI: `/shipping-methods`

    * Read
    
        * Method: `GET`
        * URI: `/shipping-methods`

    * Update
    
        * Method: `PUT`
        * URI: `/shipping-methods`

    * Delete
    
        * Method: `DELETE`
        * URI: `/shipping-methods`
    
* #### Payment Methods

    * Attributes
    
        * active: String
        * name: String
        * options: String
        * store_id: Integer
        * title: String (Translatable)
        * description: String (Translatable)
    
    * Create
    
        * Method: `POST`
        * URI: `/payment-methods`

    * Read
    
        * Method: `GET`
        * URI: `/payment-methods`

    * Update
    
        * Method: `PUT`
        * URI: `/payment-methods`

    * Delete
    
        * Method: `DELETE`
        * URI: `/payment-methods`









