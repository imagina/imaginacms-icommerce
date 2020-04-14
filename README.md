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
    * Read
    * Update
    * Delete

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
    * Create
    * Read
    * Update
    * Delete
    
* #### Carts

    * Attributes
    * Create
    * Read
    * Update
    * Delete
    
* #### Products Cart

    * Attributes
    * Create
    * Read
    * Update
    * Delete
    
* #### Coupons

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Manufacturers

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Options

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Option Values

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Orders

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Tax Class

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### Tax Rates

    * Attributes
    * Create
    * Read
    * Update
    * Delete

* #### WishList

    * Attributes
    * Create
    * Read
    * Update
    * Delete


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









