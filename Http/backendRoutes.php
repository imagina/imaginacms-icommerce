<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommerce'], function (Router $router) {
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
    $router->bind('productdiscount', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductDiscountRepository')->find($id);
    });
    $router->get('productdiscounts', [
        'as' => 'admin.icommerce.productdiscount.index',
        'uses' => 'ProductDiscountController@index',
        'middleware' => 'can:icommerce.productdiscounts.index'
    ]);
    $router->get('productdiscounts/create', [
        'as' => 'admin.icommerce.productdiscount.create',
        'uses' => 'ProductDiscountController@create',
        'middleware' => 'can:icommerce.productdiscounts.create'
    ]);
    $router->post('productdiscounts', [
        'as' => 'admin.icommerce.productdiscount.store',
        'uses' => 'ProductDiscountController@store',
        'middleware' => 'can:icommerce.productdiscounts.create'
    ]);
    $router->get('productdiscounts/{productdiscount}/edit', [
        'as' => 'admin.icommerce.productdiscount.edit',
        'uses' => 'ProductDiscountController@edit',
        'middleware' => 'can:icommerce.productdiscounts.edit'
    ]);
    $router->put('productdiscounts/{productdiscount}', [
        'as' => 'admin.icommerce.productdiscount.update',
        'uses' => 'ProductDiscountController@update',
        'middleware' => 'can:icommerce.productdiscounts.edit'
    ]);
    $router->delete('productdiscounts/{productdiscount}', [
        'as' => 'admin.icommerce.productdiscount.destroy',
        'uses' => 'ProductDiscountController@destroy',
        'middleware' => 'can:icommerce.productdiscounts.destroy'
    ]);
    $router->bind('optionvalue', function ($id) {
        return app('Modules\Icommerce\Repositories\OptionValueRepository')->find($id);
    });
    $router->get('optionvalues', [
        'as' => 'admin.icommerce.optionvalue.index',
        'uses' => 'OptionValueController@index',
        'middleware' => 'can:icommerce.optionvalues.index'
    ]);
    $router->get('optionvalues/create', [
        'as' => 'admin.icommerce.optionvalue.create',
        'uses' => 'OptionValueController@create',
        'middleware' => 'can:icommerce.optionvalues.create'
    ]);
    $router->post('optionvalues', [
        'as' => 'admin.icommerce.optionvalue.store',
        'uses' => 'OptionValueController@store',
        'middleware' => 'can:icommerce.optionvalues.create'
    ]);
    $router->get('optionvalues/{optionvalue}/edit', [
        'as' => 'admin.icommerce.optionvalue.edit',
        'uses' => 'OptionValueController@edit',
        'middleware' => 'can:icommerce.optionvalues.edit'
    ]);
    $router->put('optionvalues/{optionvalue}', [
        'as' => 'admin.icommerce.optionvalue.update',
        'uses' => 'OptionValueController@update',
        'middleware' => 'can:icommerce.optionvalues.edit'
    ]);
    $router->delete('optionvalues/{optionvalue}', [
        'as' => 'admin.icommerce.optionvalue.destroy',
        'uses' => 'OptionValueController@destroy',
        'middleware' => 'can:icommerce.optionvalues.destroy'
    ]);
    $router->bind('productoption', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductOptionRepository')->find($id);
    });
    $router->get('productoptions', [
        'as' => 'admin.icommerce.productoption.index',
        'uses' => 'ProductOptionController@index',
        'middleware' => 'can:icommerce.productoptions.index'
    ]);
    $router->get('productoptions/create', [
        'as' => 'admin.icommerce.productoption.create',
        'uses' => 'ProductOptionController@create',
        'middleware' => 'can:icommerce.productoptions.create'
    ]);
    $router->post('productoptions', [
        'as' => 'admin.icommerce.productoption.store',
        'uses' => 'ProductOptionController@store',
        'middleware' => 'can:icommerce.productoptions.create'
    ]);
    $router->get('productoptions/{productoption}/edit', [
        'as' => 'admin.icommerce.productoption.edit',
        'uses' => 'ProductOptionController@edit',
        'middleware' => 'can:icommerce.productoptions.edit'
    ]);
    $router->put('productoptions/{productoption}', [
        'as' => 'admin.icommerce.productoption.update',
        'uses' => 'ProductOptionController@update',
        'middleware' => 'can:icommerce.productoptions.edit'
    ]);
    $router->delete('productoptions/{productoption}', [
        'as' => 'admin.icommerce.productoption.destroy',
        'uses' => 'ProductOptionController@destroy',
        'middleware' => 'can:icommerce.productoptions.destroy'
    ]);
    $router->bind('productoptionvalue', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductOptionValueRepository')->find($id);
    });
    $router->get('productoptionvalues', [
        'as' => 'admin.icommerce.productoptionvalue.index',
        'uses' => 'ProductOptionValueController@index',
        'middleware' => 'can:icommerce.productoptionvalues.index'
    ]);
    $router->get('productoptionvalues/create', [
        'as' => 'admin.icommerce.productoptionvalue.create',
        'uses' => 'ProductOptionValueController@create',
        'middleware' => 'can:icommerce.productoptionvalues.create'
    ]);
    $router->post('productoptionvalues', [
        'as' => 'admin.icommerce.productoptionvalue.store',
        'uses' => 'ProductOptionValueController@store',
        'middleware' => 'can:icommerce.productoptionvalues.create'
    ]);
    $router->get('productoptionvalues/{productoptionvalue}/edit', [
        'as' => 'admin.icommerce.productoptionvalue.edit',
        'uses' => 'ProductOptionValueController@edit',
        'middleware' => 'can:icommerce.productoptionvalues.edit'
    ]);
    $router->put('productoptionvalues/{productoptionvalue}', [
        'as' => 'admin.icommerce.productoptionvalue.update',
        'uses' => 'ProductOptionValueController@update',
        'middleware' => 'can:icommerce.productoptionvalues.edit'
    ]);
    $router->delete('productoptionvalues/{productoptionvalue}', [
        'as' => 'admin.icommerce.productoptionvalue.destroy',
        'uses' => 'ProductOptionValueController@destroy',
        'middleware' => 'can:icommerce.productoptionvalues.destroy'
    ]);

    $router->bind('orderoption', function ($id) {
        return app('Modules\Icommerce\Repositories\OrderOptionRepository')->find($id);
    });
    $router->get('orderoptions', [
        'as' => 'admin.icommerce.orderoption.index',
        'uses' => 'OrderOptionController@index',
        'middleware' => 'can:icommerce.orderoptions.index'
    ]);
    $router->get('orderoptions/create', [
        'as' => 'admin.icommerce.orderoption.create',
        'uses' => 'OrderOptionController@create',
        'middleware' => 'can:icommerce.orderoptions.create'
    ]);
    $router->post('orderoptions', [
        'as' => 'admin.icommerce.orderoption.store',
        'uses' => 'OrderOptionController@store',
        'middleware' => 'can:icommerce.orderoptions.create'
    ]);
    $router->get('orderoptions/{orderoption}/edit', [
        'as' => 'admin.icommerce.orderoption.edit',
        'uses' => 'OrderOptionController@edit',
        'middleware' => 'can:icommerce.orderoptions.edit'
    ]);
    $router->put('orderoptions/{orderoption}', [
        'as' => 'admin.icommerce.orderoption.update',
        'uses' => 'OrderOptionController@update',
        'middleware' => 'can:icommerce.orderoptions.edit'
    ]);
    $router->delete('orderoptions/{orderoption}', [
        'as' => 'admin.icommerce.orderoption.destroy',
        'uses' => 'OrderOptionController@destroy',
        'middleware' => 'can:icommerce.orderoptions.destroy'
    ]);
    $router->bind('orderhistory', function ($id) {
        return app('Modules\Icommerce\Repositories\OrderHistoryRepository')->find($id);
    });
    $router->get('orderhistories', [
        'as' => 'admin.icommerce.orderhistory.index',
        'uses' => 'OrderHistoryController@index',
        'middleware' => 'can:icommerce.orderhistories.index'
    ]);
    $router->get('orderhistories/create', [
        'as' => 'admin.icommerce.orderhistory.create',
        'uses' => 'OrderHistoryController@create',
        'middleware' => 'can:icommerce.orderhistories.create'
    ]);
    $router->post('orderhistories', [
        'as' => 'admin.icommerce.orderhistory.store',
        'uses' => 'OrderHistoryController@store',
        'middleware' => 'can:icommerce.orderhistories.create'
    ]);
    $router->get('orderhistories/{orderhistory}/edit', [
        'as' => 'admin.icommerce.orderhistory.edit',
        'uses' => 'OrderHistoryController@edit',
        'middleware' => 'can:icommerce.orderhistories.edit'
    ]);
    $router->put('orderhistories/{orderhistory}', [
        'as' => 'admin.icommerce.orderhistory.update',
        'uses' => 'OrderHistoryController@update',
        'middleware' => 'can:icommerce.orderhistories.edit'
    ]);
    $router->delete('orderhistories/{orderhistory}', [
        'as' => 'admin.icommerce.orderhistory.destroy',
        'uses' => 'OrderHistoryController@destroy',
        'middleware' => 'can:icommerce.orderhistories.destroy'
    ]);

    $router->bind('couponhistory', function ($id) {
        return app('Modules\Icommerce\Repositories\CouponHistoryRepository')->find($id);
    });
    $router->get('couponhistories', [
        'as' => 'admin.icommerce.couponhistory.index',
        'uses' => 'CouponHistoryController@index',
        'middleware' => 'can:icommerce.couponhistories.index'
    ]);
    $router->get('couponhistories/create', [
        'as' => 'admin.icommerce.couponhistory.create',
        'uses' => 'CouponHistoryController@create',
        'middleware' => 'can:icommerce.couponhistories.create'
    ]);
    $router->post('couponhistories', [
        'as' => 'admin.icommerce.couponhistory.store',
        'uses' => 'CouponHistoryController@store',
        'middleware' => 'can:icommerce.couponhistories.create'
    ]);
    $router->get('couponhistories/{couponhistory}/edit', [
        'as' => 'admin.icommerce.couponhistory.edit',
        'uses' => 'CouponHistoryController@edit',
        'middleware' => 'can:icommerce.couponhistories.edit'
    ]);
    $router->put('couponhistories/{couponhistory}', [
        'as' => 'admin.icommerce.couponhistory.update',
        'uses' => 'CouponHistoryController@update',
        'middleware' => 'can:icommerce.couponhistories.edit'
    ]);
    $router->delete('couponhistories/{couponhistory}', [
        'as' => 'admin.icommerce.couponhistory.destroy',
        'uses' => 'CouponHistoryController@destroy',
        'middleware' => 'can:icommerce.couponhistories.destroy'
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


    $router->bind('taxrate', function ($id) {
        return app('Modules\Icommerce\Repositories\TaxRateRepository')->find($id);
    });
    $router->get('taxrates', [
        'as' => 'admin.icommerce.taxrate.index',
        'uses' => 'TaxRateController@index',
        'middleware' => 'can:icommerce.taxrates.index'
    ]);
    $router->get('taxrates/create', [
        'as' => 'admin.icommerce.taxrate.create',
        'uses' => 'TaxRateController@create',
        'middleware' => 'can:icommerce.taxrates.create'
    ]);
    $router->post('taxrates', [
        'as' => 'admin.icommerce.taxrate.store',
        'uses' => 'TaxRateController@store',
        'middleware' => 'can:icommerce.taxrates.create'
    ]);
    $router->get('taxrates/{taxrate}/edit', [
        'as' => 'admin.icommerce.taxrate.edit',
        'uses' => 'TaxRateController@edit',
        'middleware' => 'can:icommerce.taxrates.edit'
    ]);
    $router->put('taxrates/{taxrate}', [
        'as' => 'admin.icommerce.taxrate.update',
        'uses' => 'TaxRateController@update',
        'middleware' => 'can:icommerce.taxrates.edit'
    ]);
    $router->delete('taxrates/{taxrate}', [
        'as' => 'admin.icommerce.taxrate.destroy',
        'uses' => 'TaxRateController@destroy',
        'middleware' => 'can:icommerce.taxrates.destroy'
    ]);
    $router->bind('taxclass', function ($id) {
        return app('Modules\Icommerce\Repositories\TaxClassRepository')->find($id);
    });
    $router->get('taxclasses', [
        'as' => 'admin.icommerce.taxclass.index',
        'uses' => 'TaxClassController@index',
        'middleware' => 'can:icommerce.taxclasses.index'
    ]);
    $router->get('taxclasses/create', [
        'as' => 'admin.icommerce.taxclass.create',
        'uses' => 'TaxClassController@create',
        'middleware' => 'can:icommerce.taxclasses.create'
    ]);
    $router->post('taxclasses', [
        'as' => 'admin.icommerce.taxclass.store',
        'uses' => 'TaxClassController@store',
        'middleware' => 'can:icommerce.taxclasses.create'
    ]);
    $router->get('taxclasses/{taxclass}/edit', [
        'as' => 'admin.icommerce.taxclass.edit',
        'uses' => 'TaxClassController@edit',
        'middleware' => 'can:icommerce.taxclasses.edit'
    ]);
    $router->put('taxclasses/{taxclass}', [
        'as' => 'admin.icommerce.taxclass.update',
        'uses' => 'TaxClassController@update',
        'middleware' => 'can:icommerce.taxclasses.edit'
    ]);
    $router->delete('taxclasses/{taxclass}', [
        'as' => 'admin.icommerce.taxclass.destroy',
        'uses' => 'TaxClassController@destroy',
        'middleware' => 'can:icommerce.taxclasses.destroy'
    ]);
    $router->bind('taxclassrate', function ($id) {
        return app('Modules\Icommerce\Repositories\TaxClassRateRepository')->find($id);
    });
    $router->get('taxclassrates', [
        'as' => 'admin.icommerce.taxclassrate.index',
        'uses' => 'TaxClassRateController@index',
        'middleware' => 'can:icommerce.taxclassrates.index'
    ]);
    $router->get('taxclassrates/create', [
        'as' => 'admin.icommerce.taxclassrate.create',
        'uses' => 'TaxClassRateController@create',
        'middleware' => 'can:icommerce.taxclassrates.create'
    ]);
    $router->post('taxclassrates', [
        'as' => 'admin.icommerce.taxclassrate.store',
        'uses' => 'TaxClassRateController@store',
        'middleware' => 'can:icommerce.taxclassrates.create'
    ]);
    $router->get('taxclassrates/{taxclassrate}/edit', [
        'as' => 'admin.icommerce.taxclassrate.edit',
        'uses' => 'TaxClassRateController@edit',
        'middleware' => 'can:icommerce.taxclassrates.edit'
    ]);
    $router->put('taxclassrates/{taxclassrate}', [
        'as' => 'admin.icommerce.taxclassrate.update',
        'uses' => 'TaxClassRateController@update',
        'middleware' => 'can:icommerce.taxclassrates.edit'
    ]);
    $router->delete('taxclassrates/{taxclassrate}', [
        'as' => 'admin.icommerce.taxclassrate.destroy',
        'uses' => 'TaxClassRateController@destroy',
        'middleware' => 'can:icommerce.taxclassrates.destroy'
    ]);
    $router->bind('itemtype', function ($id) {
        return app('Modules\Icommerce\Repositories\ItemTypeRepository')->find($id);
    });
    $router->get('itemtypes', [
        'as' => 'admin.icommerce.itemtype.index',
        'uses' => 'ItemTypeController@index',
        'middleware' => 'can:icommerce.itemtypes.index'
    ]);
    $router->get('itemtypes/create', [
        'as' => 'admin.icommerce.itemtype.create',
        'uses' => 'ItemTypeController@create',
        'middleware' => 'can:icommerce.itemtypes.create'
    ]);
    $router->post('itemtypes', [
        'as' => 'admin.icommerce.itemtype.store',
        'uses' => 'ItemTypeController@store',
        'middleware' => 'can:icommerce.itemtypes.create'
    ]);
    $router->get('itemtypes/{itemtype}/edit', [
        'as' => 'admin.icommerce.itemtype.edit',
        'uses' => 'ItemTypeController@edit',
        'middleware' => 'can:icommerce.itemtypes.edit'
    ]);
    $router->put('itemtypes/{itemtype}', [
        'as' => 'admin.icommerce.itemtype.update',
        'uses' => 'ItemTypeController@update',
        'middleware' => 'can:icommerce.itemtypes.edit'
    ]);
    $router->delete('itemtypes/{itemtype}', [
        'as' => 'admin.icommerce.itemtype.destroy',
        'uses' => 'ItemTypeController@destroy',
        'middleware' => 'can:icommerce.itemtypes.destroy'
    ]);

    $router->bind('productlist', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductListRepository')->find($id);
    });
    $router->get('productlists', [
        'as' => 'admin.icommerce.productlist.index',
        'uses' => 'ProductListController@index',
        'middleware' => 'can:icommerce.productlists.index'
    ]);
    $router->get('productlists/create', [
        'as' => 'admin.icommerce.productlist.create',
        'uses' => 'ProductListController@create',
        'middleware' => 'can:icommerce.productlists.create'
    ]);
    $router->post('productlists', [
        'as' => 'admin.icommerce.productlist.store',
        'uses' => 'ProductListController@store',
        'middleware' => 'can:icommerce.productlists.create'
    ]);
    $router->get('productlists/{productlist}/edit', [
        'as' => 'admin.icommerce.productlist.edit',
        'uses' => 'ProductListController@edit',
        'middleware' => 'can:icommerce.productlists.edit'
    ]);
    $router->put('productlists/{productlist}', [
        'as' => 'admin.icommerce.productlist.update',
        'uses' => 'ProductListController@update',
        'middleware' => 'can:icommerce.productlists.edit'
    ]);
    $router->delete('productlists/{productlist}', [
        'as' => 'admin.icommerce.productlist.destroy',
        'uses' => 'ProductListController@destroy',
        'middleware' => 'can:icommerce.productlists.destroy'
    ]);
    $router->bind('paymentmethod', function ($id) {
        return app('Modules\Icommerce\Repositories\PaymentMethodRepository')->find($id);
    });
    $router->get('paymentmethods', [
        'as' => 'admin.icommerce.paymentmethod.index',
        'uses' => 'PaymentMethodController@index',
        'middleware' => 'can:icommerce.paymentmethods.index'
    ]);
    $router->get('paymentmethods/create', [
        'as' => 'admin.icommerce.paymentmethod.create',
        'uses' => 'PaymentMethodController@create',
        'middleware' => 'can:icommerce.paymentmethods.create'
    ]);
    $router->post('paymentmethods', [
        'as' => 'admin.icommerce.paymentmethod.store',
        'uses' => 'PaymentMethodController@store',
        'middleware' => 'can:icommerce.paymentmethods.create'
    ]);
    $router->get('paymentmethods/{paymentmethod}/edit', [
        'as' => 'admin.icommerce.paymentmethod.edit',
        'uses' => 'PaymentMethodController@edit',
        'middleware' => 'can:icommerce.paymentmethods.edit'
    ]);
    $router->put('paymentmethods/{paymentmethod}', [
        'as' => 'admin.icommerce.paymentmethod.update',
        'uses' => 'PaymentMethodController@update',
        'middleware' => 'can:icommerce.paymentmethods.edit'
    ]);
    $router->delete('paymentmethods/{paymentmethod}', [
        'as' => 'admin.icommerce.paymentmethod.destroy',
        'uses' => 'PaymentMethodController@destroy',
        'middleware' => 'can:icommerce.paymentmethods.destroy'
    ]);
    
    $router->bind('shippingmethod', function ($id) {
        return app('Modules\Icommerce\Repositories\ShippingMethodRepository')->find($id);
    });
    $router->get('shippingmethods', [
        'as' => 'admin.icommerce.shippingmethod.index',
        'uses' => 'ShippingMethodController@index',
        'middleware' => 'can:icommerce.shippingmethods.index'
    ]);
    $router->get('shippingmethods/create', [
        'as' => 'admin.icommerce.shippingmethod.create',
        'uses' => 'ShippingMethodController@create',
        'middleware' => 'can:icommerce.shippingmethods.create'
    ]);
    $router->post('shippingmethods', [
        'as' => 'admin.icommerce.shippingmethod.store',
        'uses' => 'ShippingMethodController@store',
        'middleware' => 'can:icommerce.shippingmethods.create'
    ]);
    $router->get('shippingmethods/{shippingmethod}/edit', [
        'as' => 'admin.icommerce.shippingmethod.edit',
        'uses' => 'ShippingMethodController@edit',
        'middleware' => 'can:icommerce.shippingmethods.edit'
    ]);
    $router->put('shippingmethods/{shippingmethod}', [
        'as' => 'admin.icommerce.shippingmethod.update',
        'uses' => 'ShippingMethodController@update',
        'middleware' => 'can:icommerce.shippingmethods.edit'
    ]);
    $router->delete('shippingmethods/{shippingmethod}', [
        'as' => 'admin.icommerce.shippingmethod.destroy',
        'uses' => 'ShippingMethodController@destroy',
        'middleware' => 'can:icommerce.shippingmethods.destroy'
    ]);
    $router->bind('shippingmethodgeozone', function ($id) {
        return app('Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository')->find($id);
    });
    $router->get('shippingmethodgeozones', [
        'as' => 'admin.icommerce.shippingmethodgeozone.index',
        'uses' => 'ShippingMethodGeozoneController@index',
        'middleware' => 'can:icommerce.shippingmethodgeozones.index'
    ]);
    $router->get('shippingmethodgeozones/create', [
        'as' => 'admin.icommerce.shippingmethodgeozone.create',
        'uses' => 'ShippingMethodGeozoneController@create',
        'middleware' => 'can:icommerce.shippingmethodgeozones.create'
    ]);
    $router->post('shippingmethodgeozones', [
        'as' => 'admin.icommerce.shippingmethodgeozone.store',
        'uses' => 'ShippingMethodGeozoneController@store',
        'middleware' => 'can:icommerce.shippingmethodgeozones.create'
    ]);
    $router->get('shippingmethodgeozones/{shippingmethodgeozone}/edit', [
        'as' => 'admin.icommerce.shippingmethodgeozone.edit',
        'uses' => 'ShippingMethodGeozoneController@edit',
        'middleware' => 'can:icommerce.shippingmethodgeozones.edit'
    ]);
    $router->put('shippingmethodgeozones/{shippingmethodgeozone}', [
        'as' => 'admin.icommerce.shippingmethodgeozone.update',
        'uses' => 'ShippingMethodGeozoneController@update',
        'middleware' => 'can:icommerce.shippingmethodgeozones.edit'
    ]);
    $router->delete('shippingmethodgeozones/{shippingmethodgeozone}', [
        'as' => 'admin.icommerce.shippingmethodgeozone.destroy',
        'uses' => 'ShippingMethodGeozoneController@destroy',
        'middleware' => 'can:icommerce.shippingmethodgeozones.destroy'
    ]);
    $router->bind('paymentmethodgeozone', function ($id) {
        return app('Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository')->find($id);
    });
    $router->get('paymentmethodgeozones', [
        'as' => 'admin.icommerce.paymentmethodgeozone.index',
        'uses' => 'PaymentMethodGeozoneController@index',
        'middleware' => 'can:icommerce.paymentmethodgeozones.index'
    ]);
    $router->get('paymentmethodgeozones/create', [
        'as' => 'admin.icommerce.paymentmethodgeozone.create',
        'uses' => 'PaymentMethodGeozoneController@create',
        'middleware' => 'can:icommerce.paymentmethodgeozones.create'
    ]);
    $router->post('paymentmethodgeozones', [
        'as' => 'admin.icommerce.paymentmethodgeozone.store',
        'uses' => 'PaymentMethodGeozoneController@store',
        'middleware' => 'can:icommerce.paymentmethodgeozones.create'
    ]);
    $router->get('paymentmethodgeozones/{paymentmethodgeozone}/edit', [
        'as' => 'admin.icommerce.paymentmethodgeozone.edit',
        'uses' => 'PaymentMethodGeozoneController@edit',
        'middleware' => 'can:icommerce.paymentmethodgeozones.edit'
    ]);
    $router->put('paymentmethodgeozones/{paymentmethodgeozone}', [
        'as' => 'admin.icommerce.paymentmethodgeozone.update',
        'uses' => 'PaymentMethodGeozoneController@update',
        'middleware' => 'can:icommerce.paymentmethodgeozones.edit'
    ]);
    $router->delete('paymentmethodgeozones/{paymentmethodgeozone}', [
        'as' => 'admin.icommerce.paymentmethodgeozone.destroy',
        'uses' => 'PaymentMethodGeozoneController@destroy',
        'middleware' => 'can:icommerce.paymentmethodgeozones.destroy'
    ]);
// append




































});
