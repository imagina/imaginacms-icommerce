<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommerce'], function (Router $router) {

    Route::get('category/ajaxparent', 'CategoryController@parentOptions');

    \CRUD::resource('icommerce','category', 'CategoryController');
    \CRUD::resource('icommerce','tag', 'TagController');
    \CRUD::resource('icommerce','currency', 'CurrencyController');
    \CRUD::resource('icommerce','shipping_courier', 'Shipping_CourierController');
    \CRUD::resource('icommerce','manufacturer', 'ManufacturerController');
    \CRUD::resource('icommerce','coupon', 'CouponController');
    \CRUD::resource('icommerce','comment', 'CommentController');


    
    /*
    $router->bind('tag', function ($id) {
        return app('Modules\Icommerce\Repositories\TagRepository')->find($id);
    });
    $router->get('tags', [
        'as' => 'admin.icommerce.tag.index',
        'uses' => 'TagController@index',
        'middleware' => 'can:icommerce.tags.index'
    ]);
    $router->get('tags/create', [
        'as' => 'admin.icommerce.tag.create',
        'uses' => 'TagController@create',
        'middleware' => 'can:icommerce.tags.create'
    ]);
    $router->post('tags', [
        'as' => 'admin.icommerce.tag.store',
        'uses' => 'TagController@store',
        'middleware' => 'can:icommerce.tags.create'
    ]);
    $router->get('tags/{tag}/edit', [
        'as' => 'admin.icommerce.tag.edit',
        'uses' => 'TagController@edit',
        'middleware' => 'can:icommerce.tags.edit'
    ]);
    $router->put('tags/{tag}', [
        'as' => 'admin.icommerce.tag.update',
        'uses' => 'TagController@update',
        'middleware' => 'can:icommerce.tags.edit'
    ]);
    $router->delete('tags/{tag}', [
        'as' => 'admin.icommerce.tag.destroy',
        'uses' => 'TagController@destroy',
        'middleware' => 'can:icommerce.tags.destroy'
    ]);
    */
    /*
    $router->bind('comment', function ($id) {
        return app('Modules\Icommerce\Repositories\CommentRepository')->find($id);
    });
    $router->get('comments', [
        'as' => 'admin.icommerce.comment.index',
        'uses' => 'CommentController@index',
        'middleware' => 'can:icommerce.comments.index'
    ]);
    $router->get('comments/create', [
        'as' => 'admin.icommerce.comment.create',
        'uses' => 'CommentController@create',
        'middleware' => 'can:icommerce.comments.create'
    ]);
    $router->post('comments', [
        'as' => 'admin.icommerce.comment.store',
        'uses' => 'CommentController@store',
        'middleware' => 'can:icommerce.comments.create'
    ]);
    $router->get('comments/{comment}/edit', [
        'as' => 'admin.icommerce.comment.edit',
        'uses' => 'CommentController@edit',
        'middleware' => 'can:icommerce.comments.edit'
    ]);
    $router->put('comments/{comment}', [
        'as' => 'admin.icommerce.comment.update',
        'uses' => 'CommentController@update',
        'middleware' => 'can:icommerce.comments.edit'
    ]);
    $router->delete('comments/{comment}', [
        'as' => 'admin.icommerce.comment.destroy',
        'uses' => 'CommentController@destroy',
        'middleware' => 'can:icommerce.comments.destroy'
    ]);
    */
    /*
    $router->bind('category', function ($id) {
        return app('Modules\Icommerce\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.icommerce.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:icommerce.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.icommerce.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:icommerce.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.icommerce.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:icommerce.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.icommerce.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:icommerce.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.icommerce.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:icommerce.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.icommerce.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:icommerce.categories.destroy'
    ]);
    */
    $router->bind('product', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductRepository')->find($id);
    });
    $router->get('products', [
        'as' => 'admin.icommerce.product.index',
        'uses' => 'ProductController@index',
        'middleware' => 'can:icommerce.products.index'
    ]);
    $router->get('products/create', [
        'as' => 'admin.icommerce.product.create',
        'uses' => 'ProductController@create',
        'middleware' => 'can:icommerce.products.create'
    ]);
    $router->post('products', [
        'as' => 'admin.icommerce.product.store',
        'uses' => 'ProductController@store',
        'middleware' => 'can:icommerce.products.create'
    ]);
    $router->get('products/{product}/edit', [
        'as' => 'admin.icommerce.product.edit',
        'uses' => 'ProductController@edit',
        'middleware' => 'can:icommerce.products.edit'
    ]);
    $router->put('products/{product}', [
        'as' => 'admin.icommerce.product.update',
        'uses' => 'ProductController@update',
        'middleware' => 'can:icommerce.products.edit'
    ]);
    $router->delete('products/{product}', [
        'as' => 'admin.icommerce.product.destroy',
        'uses' => 'ProductController@destroy',
        'middleware' => 'can:icommerce.products.destroy'
    ]);

    $router->post('products/deleteSubproduct/{id}', [
        'as'    => 'admin.icommerce.product.deleteSubproduct',
        'uses'  => 'ProductController@deleteSubproduct'
    ]); 

    $router->post('product/upload/image', [
        'as' => 'icommerce.gallery.upload',
        'uses' => 'ProductController@uploadGalleryimage',
    ]);

    $router->post('product/delete/img', [
        'as' => 'icommerce.gallery.delete',
        'uses' => 'ProductController@deleteGalleryimage',
    ]);

    $router->get('products/searchProducts', [
        'as'    => 'admin.icommerce.product.searchProducts',
        'uses'  => 'ProductController@searchProducts'
    ]); 

    $router->get('products/searchProductsRelated', [
        'as'    => 'admin.icommerce.product.searchProductsRelated',
        'uses'  => 'ProductController@searchProductsRelated'
    ]);

    /*
    $router->bind('manufacturer', function ($id) {
        return app('Modules\Icommerce\Repositories\ManufacturerRepository')->find($id);
    });
    $router->get('manufacturers', [
        'as' => 'admin.icommerce.manufacturer.index',
        'uses' => 'ManufacturerController@index',
        'middleware' => 'can:icommerce.manufacturers.index'
    ]);
    $router->get('manufacturers/create', [
        'as' => 'admin.icommerce.manufacturer.create',
        'uses' => 'ManufacturerController@create',
        'middleware' => 'can:icommerce.manufacturers.create'
    ]);
    $router->post('manufacturers', [
        'as' => 'admin.icommerce.manufacturer.store',
        'uses' => 'ManufacturerController@store',
        'middleware' => 'can:icommerce.manufacturers.create'
    ]);
    $router->get('manufacturers/{manufacturer}/edit', [
        'as' => 'admin.icommerce.manufacturer.edit',
        'uses' => 'ManufacturerController@edit',
        'middleware' => 'can:icommerce.manufacturers.edit'
    ]);
    $router->put('manufacturers/{manufacturer}', [
        'as' => 'admin.icommerce.manufacturer.update',
        'uses' => 'ManufacturerController@update',
        'middleware' => 'can:icommerce.manufacturers.edit'
    ]);
    $router->delete('manufacturers/{manufacturer}', [
        'as' => 'admin.icommerce.manufacturer.destroy',
        'uses' => 'ManufacturerController@destroy',
        'middleware' => 'can:icommerce.manufacturers.destroy'
    ]);
    */

    $router->bind('option', function ($id) {
        return app('Modules\Icommerce\Repositories\OptionRepository')->find($id);
    });
    $router->get('options', [
        'as' => 'admin.icommerce.option.index',
        'uses' => 'OptionController@index',
        'middleware' => 'can:icommerce.options.index'
    ]);
    $router->get('options/create', [
        'as' => 'admin.icommerce.option.create',
        'uses' => 'OptionController@create',
        'middleware' => 'can:icommerce.options.create'
    ]);
    $router->post('options', [
        'as' => 'admin.icommerce.option.store',
        'uses' => 'OptionController@store',
        'middleware' => 'can:icommerce.options.create'
    ]);
    $router->get('options/{option}/edit', [
        'as' => 'admin.icommerce.option.edit',
        'uses' => 'OptionController@edit',
        'middleware' => 'can:icommerce.options.edit'
    ]);
    $router->put('options/{option}', [
        'as' => 'admin.icommerce.option.update',
        'uses' => 'OptionController@update',
        'middleware' => 'can:icommerce.options.edit'
    ]);
    $router->delete('options/{option}', [
        'as' => 'admin.icommerce.option.destroy',
        'uses' => 'OptionController@destroy',
        'middleware' => 'can:icommerce.options.destroy'
    ]);

    $router->post('options/deleteOptionValue/{id}', [
        'as'    => 'admin.icommerce.option.deleteOptionValue',
        'uses'  => 'OptionController@deleteOptionValue'
    ]); 

    /*
    $router->bind('coupon', function ($id) {
        return app('Modules\Icommerce\Repositories\CouponRepository')->find($id);
    });
    $router->get('coupons', [
        'as' => 'admin.icommerce.coupon.index',
        'uses' => 'CouponController@index',
        'middleware' => 'can:icommerce.coupons.index'
    ]);
    $router->get('coupons/create', [
        'as' => 'admin.icommerce.coupon.create',
        'uses' => 'CouponController@create',
        'middleware' => 'can:icommerce.coupons.create'
    ]);
    $router->post('coupons', [
        'as' => 'admin.icommerce.coupon.store',
        'uses' => 'CouponController@store',
        'middleware' => 'can:icommerce.coupons.create'
    ]);
    $router->get('coupons/{coupon}/edit', [
        'as' => 'admin.icommerce.coupon.edit',
        'uses' => 'CouponController@edit',
        'middleware' => 'can:icommerce.coupons.edit'
    ]);
    $router->put('coupons/{coupon}', [
        'as' => 'admin.icommerce.coupon.update',
        'uses' => 'CouponController@update',
        'middleware' => 'can:icommerce.coupons.edit'
    ]);
    $router->delete('coupons/{coupon}', [
        'as' => 'admin.icommerce.coupon.destroy',
        'uses' => 'CouponController@destroy',
        'middleware' => 'can:icommerce.coupons.destroy'
    ]);
    */

    /*
    $router->bind('shipping_courier', function ($id) {
        return app('Modules\Icommerce\Repositories\Shipping_CourierRepository')->find($id);
    });
    $router->get('shipping_couriers', [
        'as' => 'admin.icommerce.shipping_courier.index',
        'uses' => 'Shipping_CourierController@index',
        'middleware' => 'can:icommerce.shipping_couriers.index'
    ]);
    $router->get('shipping_couriers/create', [
        'as' => 'admin.icommerce.shipping_courier.create',
        'uses' => 'Shipping_CourierController@create',
        'middleware' => 'can:icommerce.shipping_couriers.create'
    ]);
    $router->post('shipping_couriers', [
        'as' => 'admin.icommerce.shipping_courier.store',
        'uses' => 'Shipping_CourierController@store',
        'middleware' => 'can:icommerce.shipping_couriers.create'
    ]);
    $router->get('shipping_couriers/{shipping_courier}/edit', [
        'as' => 'admin.icommerce.shipping_courier.edit',
        'uses' => 'Shipping_CourierController@edit',
        'middleware' => 'can:icommerce.shipping_couriers.edit'
    ]);
    $router->put('shipping_couriers/{shipping_courier}', [
        'as' => 'admin.icommerce.shipping_courier.update',
        'uses' => 'Shipping_CourierController@update',
        'middleware' => 'can:icommerce.shipping_couriers.edit'
    ]);
    $router->delete('shipping_couriers/{shipping_courier}', [
        'as' => 'admin.icommerce.shipping_courier.destroy',
        'uses' => 'Shipping_CourierController@destroy',
        'middleware' => 'can:icommerce.shipping_couriers.destroy'
    ]);
    */

    /*
    $router->bind('currency', function ($id) {
        return app('Modules\Icommerce\Repositories\CurrencyRepository')->find($id);
    });
    $router->get('currencies', [
        'as' => 'admin.icommerce.currency.index',
        'uses' => 'CurrencyController@index',
        'middleware' => 'can:icommerce.currencies.index'
    ]);
    $router->get('currencies/create', [
        'as' => 'admin.icommerce.currency.create',
        'uses' => 'CurrencyController@create',
        'middleware' => 'can:icommerce.currencies.create'
    ]);
    $router->post('currencies', [
        'as' => 'admin.icommerce.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'can:icommerce.currencies.create'
    ]);
    $router->get('currencies/{currency}/edit', [
        'as' => 'admin.icommerce.currency.edit',
        'uses' => 'CurrencyController@edit',
        'middleware' => 'can:icommerce.currencies.edit'
    ]);
    $router->put('currencies/{currency}', [
        'as' => 'admin.icommerce.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:icommerce.currencies.edit'
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.icommerce.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:icommerce.currencies.destroy'
    ]);
    */

    $router->bind('order', function ($id) {
        return app('Modules\Icommerce\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.icommerce.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:icommerce.orders.index'
    ]);
    $router->get('orders/create', [
        'as' => 'admin.icommerce.order.create',
        'uses' => 'OrderController@create',
        'middleware' => 'can:icommerce.orders.create'
    ]);
    $router->post('orders', [
        'as' => 'admin.icommerce.order.store',
        'uses' => 'OrderController@store',
        'middleware' => 'can:icommerce.orders.create'
    ]);
    $router->get('orders/{order}/edit', [
        'as' => 'admin.icommerce.order.edit',
        'uses' => 'OrderController@edit',
        'middleware' => 'can:icommerce.orders.edit'
    ]);
    $router->put('orders/{order}', [
        'as' => 'admin.icommerce.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:icommerce.orders.edit'
    ]);
    $router->delete('orders/{order}', [
        'as' => 'admin.icommerce.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:icommerce.orders.destroy'
    ]);

    $router->bind('product_discount', function ($id) {
        return app('Modules\Icommerce\Repositories\Product_DiscountRepository')->find($id);
    });
    $router->get('product_discounts', [
        'as' => 'admin.icommerce.product_discount.index',
        'uses' => 'Product_DiscountController@index',
        'middleware' => 'can:icommerce.product_discounts.index'
    ]);
    $router->get('product_discounts/create', [
        'as' => 'admin.icommerce.product_discount.create',
        'uses' => 'Product_DiscountController@create',
        'middleware' => 'can:icommerce.product_discounts.create'
    ]);
    $router->post('product_discounts', [
        'as' => 'admin.icommerce.product_discount.store',
        'uses' => 'Product_DiscountController@store',
        'middleware' => 'can:icommerce.product_discounts.create'
    ]);
    $router->get('product_discounts/{product_discount}/edit', [
        'as' => 'admin.icommerce.product_discount.edit',
        'uses' => 'Product_DiscountController@edit',
        'middleware' => 'can:icommerce.product_discounts.edit'
    ]);
    $router->put('product_discounts/{product_discount}', [
        'as' => 'admin.icommerce.product_discount.update',
        'uses' => 'Product_DiscountController@update',
        'middleware' => 'can:icommerce.product_discounts.edit'
    ]);
    $router->delete('product_discounts/{product_discount}', [
        'as' => 'admin.icommerce.product_discount.destroy',
        'uses' => 'Product_DiscountController@destroy',
        'middleware' => 'can:icommerce.product_discounts.destroy'
    ]);


    $router->bind('option_value', function ($id) {
        return app('Modules\Icommerce\Repositories\Option_ValueRepository')->find($id);
    });
    $router->get('option_values', [
        'as' => 'admin.icommerce.option_value.index',
        'uses' => 'Option_ValueController@index',
        'middleware' => 'can:icommerce.option_values.index'
    ]);
    $router->get('option_values/create', [
        'as' => 'admin.icommerce.option_value.create',
        'uses' => 'Option_ValueController@create',
        'middleware' => 'can:icommerce.option_values.create'
    ]);
    $router->post('option_values', [
        'as' => 'admin.icommerce.option_value.store',
        'uses' => 'Option_ValueController@store',
        'middleware' => 'can:icommerce.option_values.create'
    ]);
    $router->get('option_values/{option_value}/edit', [
        'as' => 'admin.icommerce.option_value.edit',
        'uses' => 'Option_ValueController@edit',
        'middleware' => 'can:icommerce.option_values.edit'
    ]);
    $router->put('option_values/{option_value}', [
        'as' => 'admin.icommerce.option_value.update',
        'uses' => 'Option_ValueController@update',
        'middleware' => 'can:icommerce.option_values.edit'
    ]);
    $router->delete('option_values/{option_value}', [
        'as' => 'admin.icommerce.option_value.destroy',
        'uses' => 'Option_ValueController@destroy',
        'middleware' => 'can:icommerce.option_values.destroy'
    ]);


    $router->bind('product_option', function ($id) {
        return app('Modules\Icommerce\Repositories\Product_OptionRepository')->find($id);
    });
    $router->get('product_options', [
        'as' => 'admin.icommerce.product_option.index',
        'uses' => 'Product_OptionController@index',
        'middleware' => 'can:icommerce.product_options.index'
    ]);
    $router->get('product_options/create', [
        'as' => 'admin.icommerce.product_option.create',
        'uses' => 'Product_OptionController@create',
        'middleware' => 'can:icommerce.product_options.create'
    ]);
    $router->post('product_options', [
        'as' => 'admin.icommerce.product_option.store',
        'uses' => 'Product_OptionController@store',
        'middleware' => 'can:icommerce.product_options.create'
    ]);
    $router->get('product_options/{product_option}/edit', [
        'as' => 'admin.icommerce.product_option.edit',
        'uses' => 'Product_OptionController@edit',
        'middleware' => 'can:icommerce.product_options.edit'
    ]);
    $router->put('product_options/{product_option}', [
        'as' => 'admin.icommerce.product_option.update',
        'uses' => 'Product_OptionController@update',
        'middleware' => 'can:icommerce.product_options.edit'
    ]);
    $router->delete('product_options/{product_option}', [
        'as' => 'admin.icommerce.product_option.destroy',
        'uses' => 'Product_OptionController@destroy',
        'middleware' => 'can:icommerce.product_options.destroy'
    ]);


    $router->bind('product_option_value', function ($id) {
        return app('Modules\Icommerce\Repositories\Product_Option_ValueRepository')->find($id);
    });
    $router->get('product_option_values', [
        'as' => 'admin.icommerce.product_option_value.index',
        'uses' => 'Product_Option_ValueController@index',
        'middleware' => 'can:icommerce.product_option_values.index'
    ]);
    $router->get('product_option_values/create', [
        'as' => 'admin.icommerce.product_option_value.create',
        'uses' => 'Product_Option_ValueController@create',
        'middleware' => 'can:icommerce.product_option_values.create'
    ]);
    $router->post('product_option_values', [
        'as' => 'admin.icommerce.product_option_value.store',
        'uses' => 'Product_Option_ValueController@store',
        'middleware' => 'can:icommerce.product_option_values.create'
    ]);
    $router->get('product_option_values/{product_option_value}/edit', [
        'as' => 'admin.icommerce.product_option_value.edit',
        'uses' => 'Product_Option_ValueController@edit',
        'middleware' => 'can:icommerce.product_option_values.edit'
    ]);
    $router->put('product_option_values/{product_option_value}', [
        'as' => 'admin.icommerce.product_option_value.update',
        'uses' => 'Product_Option_ValueController@update',
        'middleware' => 'can:icommerce.product_option_values.edit'
    ]);
    $router->delete('product_option_values/{product_option_value}', [
        'as' => 'admin.icommerce.product_option_value.destroy',
        'uses' => 'Product_Option_ValueController@destroy',
        'middleware' => 'can:icommerce.product_option_values.destroy'
    ]);


    $router->bind('order_product', function ($id) {
        return app('Modules\Icommerce\Repositories\Order_ProductRepository')->find($id);
    });
    $router->get('order_products', [
        'as' => 'admin.icommerce.order_product.index',
        'uses' => 'Order_ProductController@index',
        'middleware' => 'can:icommerce.order_products.index'
    ]);
    $router->get('order_products/create', [
        'as' => 'admin.icommerce.order_product.create',
        'uses' => 'Order_ProductController@create',
        'middleware' => 'can:icommerce.order_products.create'
    ]);
    $router->post('order_products', [
        'as' => 'admin.icommerce.order_product.store',
        'uses' => 'Order_ProductController@store',
        'middleware' => 'can:icommerce.order_products.create'
    ]);
    $router->get('order_products/{order_product}/edit', [
        'as' => 'admin.icommerce.order_product.edit',
        'uses' => 'Order_ProductController@edit',
        'middleware' => 'can:icommerce.order_products.edit'
    ]);
    $router->put('order_products/{order_product}', [
        'as' => 'admin.icommerce.order_product.update',
        'uses' => 'Order_ProductController@update',
        'middleware' => 'can:icommerce.order_products.edit'
    ]);
    $router->delete('order_products/{order_product}', [
        'as' => 'admin.icommerce.order_product.destroy',
        'uses' => 'Order_ProductController@destroy',
        'middleware' => 'can:icommerce.order_products.destroy'
    ]);


    $router->bind('order_option', function ($id) {
        return app('Modules\Icommerce\Repositories\Order_OptionRepository')->find($id);
    });
    $router->get('order_options', [
        'as' => 'admin.icommerce.order_option.index',
        'uses' => 'Order_OptionController@index',
        'middleware' => 'can:icommerce.order_options.index'
    ]);
    $router->get('order_options/create', [
        'as' => 'admin.icommerce.order_option.create',
        'uses' => 'Order_OptionController@create',
        'middleware' => 'can:icommerce.order_options.create'
    ]);
    $router->post('order_options', [
        'as' => 'admin.icommerce.order_option.store',
        'uses' => 'Order_OptionController@store',
        'middleware' => 'can:icommerce.order_options.create'
    ]);
    $router->get('order_options/{order_option}/edit', [
        'as' => 'admin.icommerce.order_option.edit',
        'uses' => 'Order_OptionController@edit',
        'middleware' => 'can:icommerce.order_options.edit'
    ]);
    $router->put('order_options/{order_option}', [
        'as' => 'admin.icommerce.order_option.update',
        'uses' => 'Order_OptionController@update',
        'middleware' => 'can:icommerce.order_options.edit'
    ]);
    $router->delete('order_options/{order_option}', [
        'as' => 'admin.icommerce.order_option.destroy',
        'uses' => 'Order_OptionController@destroy',
        'middleware' => 'can:icommerce.order_options.destroy'
    ]);


    $router->bind('order_history', function ($id) {
        return app('Modules\Icommerce\Repositories\Order_HistoryRepository')->find($id);
    });
    $router->get('order_histories', [
        'as' => 'admin.icommerce.order_history.index',
        'uses' => 'Order_HistoryController@index',
        'middleware' => 'can:icommerce.order_histories.index'
    ]);
    $router->get('order_histories/create', [
        'as' => 'admin.icommerce.order_history.create',
        'uses' => 'Order_HistoryController@create',
        'middleware' => 'can:icommerce.order_histories.create'
    ]);
    $router->post('order_histories', [
        'as' => 'admin.icommerce.order_history.store',
        'uses' => 'Order_HistoryController@store',
        'middleware' => 'can:icommerce.order_histories.create'
    ]);
    $router->get('order_histories/{order_history}/edit', [
        'as' => 'admin.icommerce.order_history.edit',
        'uses' => 'Order_HistoryController@edit',
        'middleware' => 'can:icommerce.order_histories.edit'
    ]);
    $router->put('order_histories/{order_history}', [
        'as' => 'admin.icommerce.order_history.update',
        'uses' => 'Order_HistoryController@update',
        'middleware' => 'can:icommerce.order_histories.edit'
    ]);
    $router->delete('order_histories/{order_history}', [
        'as' => 'admin.icommerce.order_history.destroy',
        'uses' => 'Order_HistoryController@destroy',
        'middleware' => 'can:icommerce.order_histories.destroy'
    ]);

    // OJO AJAX
    $router->post('order_histories/addHistory', [
        'as'    => 'admin.icommerce.order_history.addHistory',
        'uses'  => 'Order_HistoryController@addHistory'
    ]); 


    $router->bind('order_shipment', function ($id) {
        return app('Modules\Icommerce\Repositories\Order_ShipmentRepository')->find($id);
    });
    $router->get('order_shipments', [
        'as' => 'admin.icommerce.order_shipment.index',
        'uses' => 'Order_ShipmentController@index',
        'middleware' => 'can:icommerce.order_shipments.index'
    ]);
    $router->get('order_shipments/create', [
        'as' => 'admin.icommerce.order_shipment.create',
        'uses' => 'Order_ShipmentController@create',
        'middleware' => 'can:icommerce.order_shipments.create'
    ]);
    $router->post('order_shipments', [
        'as' => 'admin.icommerce.order_shipment.store',
        'uses' => 'Order_ShipmentController@store',
        'middleware' => 'can:icommerce.order_shipments.create'
    ]);
    $router->get('order_shipments/{order_shipment}/edit', [
        'as' => 'admin.icommerce.order_shipment.edit',
        'uses' => 'Order_ShipmentController@edit',
        'middleware' => 'can:icommerce.order_shipments.edit'
    ]);
    $router->put('order_shipments/{order_shipment}', [
        'as' => 'admin.icommerce.order_shipment.update',
        'uses' => 'Order_ShipmentController@update',
        'middleware' => 'can:icommerce.order_shipments.edit'
    ]);
    $router->delete('order_shipments/{order_shipment}', [
        'as' => 'admin.icommerce.order_shipment.destroy',
        'uses' => 'Order_ShipmentController@destroy',
        'middleware' => 'can:icommerce.order_shipments.destroy'
    ]);


    $router->bind('coupon_category', function ($id) {
        return app('Modules\Icommerce\Repositories\Coupon_CategoryRepository')->find($id);
    });
    $router->get('coupon_categories', [
        'as' => 'admin.icommerce.coupon_category.index',
        'uses' => 'Coupon_CategoryController@index',
        'middleware' => 'can:icommerce.coupon_categories.index'
    ]);
    $router->get('coupon_categories/create', [
        'as' => 'admin.icommerce.coupon_category.create',
        'uses' => 'Coupon_CategoryController@create',
        'middleware' => 'can:icommerce.coupon_categories.create'
    ]);
    $router->post('coupon_categories', [
        'as' => 'admin.icommerce.coupon_category.store',
        'uses' => 'Coupon_CategoryController@store',
        'middleware' => 'can:icommerce.coupon_categories.create'
    ]);
    $router->get('coupon_categories/{coupon_category}/edit', [
        'as' => 'admin.icommerce.coupon_category.edit',
        'uses' => 'Coupon_CategoryController@edit',
        'middleware' => 'can:icommerce.coupon_categories.edit'
    ]);
    $router->put('coupon_categories/{coupon_category}', [
        'as' => 'admin.icommerce.coupon_category.update',
        'uses' => 'Coupon_CategoryController@update',
        'middleware' => 'can:icommerce.coupon_categories.edit'
    ]);
    $router->delete('coupon_categories/{coupon_category}', [
        'as' => 'admin.icommerce.coupon_category.destroy',
        'uses' => 'Coupon_CategoryController@destroy',
        'middleware' => 'can:icommerce.coupon_categories.destroy'
    ]);



    $router->bind('coupon_product', function ($id) {
        return app('Modules\Icommerce\Repositories\Coupon_ProductRepository')->find($id);
    });
    $router->get('coupon_products', [
        'as' => 'admin.icommerce.coupon_product.index',
        'uses' => 'Coupon_ProductController@index',
        'middleware' => 'can:icommerce.coupon_products.index'
    ]);
    $router->get('coupon_products/create', [
        'as' => 'admin.icommerce.coupon_product.create',
        'uses' => 'Coupon_ProductController@create',
        'middleware' => 'can:icommerce.coupon_products.create'
    ]);
    $router->post('coupon_products', [
        'as' => 'admin.icommerce.coupon_product.store',
        'uses' => 'Coupon_ProductController@store',
        'middleware' => 'can:icommerce.coupon_products.create'
    ]);
    $router->get('coupon_products/{coupon_product}/edit', [
        'as' => 'admin.icommerce.coupon_product.edit',
        'uses' => 'Coupon_ProductController@edit',
        'middleware' => 'can:icommerce.coupon_products.edit'
    ]);
    $router->put('coupon_products/{coupon_product}', [
        'as' => 'admin.icommerce.coupon_product.update',
        'uses' => 'Coupon_ProductController@update',
        'middleware' => 'can:icommerce.coupon_products.edit'
    ]);
    $router->delete('coupon_products/{coupon_product}', [
        'as' => 'admin.icommerce.coupon_product.destroy',
        'uses' => 'Coupon_ProductController@destroy',
        'middleware' => 'can:icommerce.coupon_products.destroy'
    ]);
    $router->bind('coupon_history', function ($id) {
        return app('Modules\Icommerce\Repositories\Coupon_HistoryRepository')->find($id);
    });
    $router->get('coupon_histories', [
        'as' => 'admin.icommerce.coupon_history.index',
        'uses' => 'Coupon_HistoryController@index',
        'middleware' => 'can:icommerce.coupon_histories.index'
    ]);
    $router->get('coupon_histories/create', [
        'as' => 'admin.icommerce.coupon_history.create',
        'uses' => 'Coupon_HistoryController@create',
        'middleware' => 'can:icommerce.coupon_histories.create'
    ]);
    $router->post('coupon_histories', [
        'as' => 'admin.icommerce.coupon_history.store',
        'uses' => 'Coupon_HistoryController@store',
        'middleware' => 'can:icommerce.coupon_histories.create'
    ]);
    $router->get('coupon_histories/{coupon_history}/edit', [
        'as' => 'admin.icommerce.coupon_history.edit',
        'uses' => 'Coupon_HistoryController@edit',
        'middleware' => 'can:icommerce.coupon_histories.edit'
    ]);
    $router->put('coupon_histories/{coupon_history}', [
        'as' => 'admin.icommerce.coupon_history.update',
        'uses' => 'Coupon_HistoryController@update',
        'middleware' => 'can:icommerce.coupon_histories.edit'
    ]);
    $router->delete('coupon_histories/{coupon_history}', [
        'as' => 'admin.icommerce.coupon_history.destroy',
        'uses' => 'Coupon_HistoryController@destroy',
        'middleware' => 'can:icommerce.coupon_histories.destroy'
    ]);



    $router->bind('wishlist', function ($id) {
        return app('Modules\Icommerce\Repositories\WishlistRepository')->find($id);
    });
    $router->get('wishlists', [
        'as' => 'admin.icommerce.wishlist.index',
        'uses' => 'WishlistController@index',
        'middleware' => 'can:icommerce.wishlists.index'
    ]);
    $router->get('wishlists/create', [
        'as' => 'admin.icommerce.wishlist.create',
        'uses' => 'WishlistController@create',
        'middleware' => 'can:icommerce.wishlists.create'
    ]);
    $router->post('wishlists', [
        'as' => 'admin.icommerce.wishlist.store',
        'uses' => 'WishlistController@store',
        'middleware' => 'can:icommerce.wishlists.create'
    ]);
    $router->get('wishlists/{wishlist}/edit', [
        'as' => 'admin.icommerce.wishlist.edit',
        'uses' => 'WishlistController@edit',
        'middleware' => 'can:icommerce.wishlists.edit'
    ]);
    $router->put('wishlists/{wishlist}', [
        'as' => 'admin.icommerce.wishlist.update',
        'uses' => 'WishlistController@update',
        'middleware' => 'can:icommerce.wishlists.edit'
    ]);
    $router->delete('wishlists/{wishlist}', [
        'as' => 'admin.icommerce.wishlist.destroy',
        'uses' => 'WishlistController@destroy',
        'middleware' => 'can:icommerce.wishlists.destroy'
    ]);



    $router->bind('payment', function ($id) {
        return app('Modules\Icommerce\Repositories\PaymentRepository')->find($id);
    });
    $router->get('payments', [
        'as' => 'admin.icommerce.payment.index',
        'uses' => 'PaymentController@index',
        'middleware' => 'can:icommerce.payments.index'
    ]);
    $router->get('payments/create', [
        'as' => 'admin.icommerce.payment.create',
        'uses' => 'PaymentController@create',
        'middleware' => 'can:icommerce.payments.create'
    ]);
    $router->post('payments', [
        'as' => 'admin.icommerce.payment.store',
        'uses' => 'PaymentController@store',
        'middleware' => 'can:icommerce.payments.create'
    ]);
    $router->get('payments/{payment}/edit', [
        'as' => 'admin.icommerce.payment.edit',
        'uses' => 'PaymentController@edit',
        'middleware' => 'can:icommerce.payments.edit'
    ]);
    $router->put('payments/{payment}', [
        'as' => 'admin.icommerce.payment.update',
        'uses' => 'PaymentController@update',
        'middleware' => 'can:icommerce.payments.edit'
    ]);
    $router->delete('payments/{payment}', [
        'as' => 'admin.icommerce.payment.destroy',
        'uses' => 'PaymentController@destroy',
        'middleware' => 'can:icommerce.payments.destroy'
    ]);



    $router->bind('shipping', function ($id) {
        return app('Modules\Icommerce\Repositories\ShippingRepository')->find($id);
    });
    $router->get('shippings', [
        'as' => 'admin.icommerce.shipping.index',
        'uses' => 'ShippingController@index',
        'middleware' => 'can:icommerce.shippings.index'
    ]);
    $router->get('shippings/create', [
        'as' => 'admin.icommerce.shipping.create',
        'uses' => 'ShippingController@create',
        'middleware' => 'can:icommerce.shippings.create'
    ]);
    $router->post('shippings', [
        'as' => 'admin.icommerce.shipping.store',
        'uses' => 'ShippingController@store',
        'middleware' => 'can:icommerce.shippings.create'
    ]);
    $router->get('shippings/{shipping}/edit', [
        'as' => 'admin.icommerce.shipping.edit',
        'uses' => 'ShippingController@edit',
        'middleware' => 'can:icommerce.shippings.edit'
    ]);
    $router->put('shippings/{shipping}', [
        'as' => 'admin.icommerce.shipping.update',
        'uses' => 'ShippingController@update',
        'middleware' => 'can:icommerce.shippings.edit'
    ]);
    $router->delete('shippings/{shipping}', [
        'as' => 'admin.icommerce.shipping.destroy',
        'uses' => 'ShippingController@destroy',
        'middleware' => 'can:icommerce.shippings.destroy'
    ]);


    
    $router->bind('slug_translations', function ($id) {
        return app('Modules\Icommerce\Repositories\Slug_TranslationsRepository')->find($id);
    });
    $router->get('slug_translations', [
        'as' => 'admin.icommerce.slug_translations.index',
        'uses' => 'Slug_TranslationsController@index',
        'middleware' => 'can:icommerce.slug_translations.index'
    ]);
    $router->get('slug_translations/create', [
        'as' => 'admin.icommerce.slug_translations.create',
        'uses' => 'Slug_TranslationsController@create',
        'middleware' => 'can:icommerce.slug_translations.create'
    ]);
    $router->post('slug_translations', [
        'as' => 'admin.icommerce.slug_translations.store',
        'uses' => 'Slug_TranslationsController@store',
        'middleware' => 'can:icommerce.slug_translations.create'
    ]);
    $router->get('slug_translations/{slug_translations}/edit', [
        'as' => 'admin.icommerce.slug_translations.edit',
        'uses' => 'Slug_TranslationsController@edit',
        'middleware' => 'can:icommerce.slug_translations.edit'
    ]);
    $router->put('slug_translations/{slug_translations}', [
        'as' => 'admin.icommerce.slug_translations.update',
        'uses' => 'Slug_TranslationsController@update',
        'middleware' => 'can:icommerce.slug_translations.edit'
    ]);
    $router->delete('slug_translations/{slug_translations}', [
        'as' => 'admin.icommerce.slug_translations.destroy',
        'uses' => 'Slug_TranslationsController@destroy',
        'middleware' => 'can:icommerce.slug_translations.destroy'
    ]);

    $router->group(['prefix' =>'bulkload'], function (Router $router){

        $router->get('index',[
            'as'=>'admin.icommerce.bulkload.index',
            'uses'=>'ProductController@indeximport',
            'middleware'=>'can:icommerce.bulkload.import',
        ]);
        $router->get('export',[
            'as'=>'admin.icommerce.bulkload.export',
            'uses'=>'ProductController@indexexport',
            'middleware'=>'can:icommerce.bulkload.export',
        ]);
        $router->post('import',[
            'as'=>'admin.icommerce.bulkload.import',
            'uses'=>'ProductController@importProducts',
             'middleware'=>'can:icommerce.bulkload.import',
        ]);
        $router->post('export',[
            'as'=>'admin.icommerce.bulkload.export',
            'uses'=>'ProductController@exportProducts',
             'middleware'=>'can:icommerce.bulkload.export',
        ]);

    });
    
    $router->bind('addresses', function ($id) {
        return app('Modules\Icommerce\Repositories\addressesRepository')->find($id);
    });
    $router->get('addresses', [
        'as' => 'admin.icommerce.addresses.index',
        'uses' => 'addressesController@index',
        'middleware' => 'can:icommerce.addresses.index'
    ]);
    $router->get('addresses/create', [
        'as' => 'admin.icommerce.addresses.create',
        'uses' => 'addressesController@create',
        'middleware' => 'can:icommerce.addresses.create'
    ]);
    $router->post('addresses', [
        'as' => 'admin.icommerce.addresses.store',
        'uses' => 'addressesController@store',
        'middleware' => 'can:icommerce.addresses.create'
    ]);
    $router->get('addresses/{addresses}/edit', [
        'as' => 'admin.icommerce.addresses.edit',
        'uses' => 'addressesController@edit',
        'middleware' => 'can:icommerce.addresses.edit'
    ]);
    $router->put('addresses/{addresses}', [
        'as' => 'admin.icommerce.addresses.update',
        'uses' => 'addressesController@update',
        'middleware' => 'can:icommerce.addresses.edit'
    ]);
    $router->delete('addresses/{addresses}', [
        'as' => 'admin.icommerce.addresses.destroy',
        'uses' => 'addressesController@destroy',
        'middleware' => 'can:icommerce.addresses.destroy'
    ]);
    $router->bind('address', function ($id) {
        return app('Modules\Icommerce\Repositories\AddressRepository')->find($id);
    });
    $router->get('addresses', [
        'as' => 'admin.icommerce.address.index',
        'uses' => 'AddressController@index',
        'middleware' => 'can:icommerce.addresses.index'
    ]);
    $router->get('addresses/create', [
        'as' => 'admin.icommerce.address.create',
        'uses' => 'AddressController@create',
        'middleware' => 'can:icommerce.addresses.create'
    ]);
    $router->post('addresses', [
        'as' => 'admin.icommerce.address.store',
        'uses' => 'AddressController@store',
        'middleware' => 'can:icommerce.addresses.create'
    ]);
    $router->get('addresses/{address}/edit', [
        'as' => 'admin.icommerce.address.edit',
        'uses' => 'AddressController@edit',
        'middleware' => 'can:icommerce.addresses.edit'
    ]);
    $router->put('addresses/{address}', [
        'as' => 'admin.icommerce.address.update',
        'uses' => 'AddressController@update',
        'middleware' => 'can:icommerce.addresses.edit'
    ]);
    $router->delete('addresses/{address}', [
        'as' => 'admin.icommerce.address.destroy',
        'uses' => 'AddressController@destroy',
        'middleware' => 'can:icommerce.addresses.destroy'
    ]);
// append



});

/*
Route::get('/api/product', 'Api\ProductController@index');
Route::get('/api/product/{id}', 'Api\ProductController@show');
*/