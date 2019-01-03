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
    $router->bind('producttag', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductTagRepository')->find($id);
    });
    $router->get('producttags', [
        'as' => 'admin.icommerce.producttag.index',
        'uses' => 'ProductTagController@index',
        'middleware' => 'can:icommerce.producttags.index'
    ]);
    $router->get('producttags/create', [
        'as' => 'admin.icommerce.producttag.create',
        'uses' => 'ProductTagController@create',
        'middleware' => 'can:icommerce.producttags.create'
    ]);
    $router->post('producttags', [
        'as' => 'admin.icommerce.producttag.store',
        'uses' => 'ProductTagController@store',
        'middleware' => 'can:icommerce.producttags.create'
    ]);
    $router->get('producttags/{producttag}/edit', [
        'as' => 'admin.icommerce.producttag.edit',
        'uses' => 'ProductTagController@edit',
        'middleware' => 'can:icommerce.producttags.edit'
    ]);
    $router->put('producttags/{producttag}', [
        'as' => 'admin.icommerce.producttag.update',
        'uses' => 'ProductTagController@update',
        'middleware' => 'can:icommerce.producttags.edit'
    ]);
    $router->delete('producttags/{producttag}', [
        'as' => 'admin.icommerce.producttag.destroy',
        'uses' => 'ProductTagController@destroy',
        'middleware' => 'can:icommerce.producttags.destroy'
    ]);
    $router->bind('productcategory', function ($id) {
        return app('Modules\Icommerce\Repositories\ProductCategoryRepository')->find($id);
    });
    $router->get('productcategories', [
        'as' => 'admin.icommerce.productcategory.index',
        'uses' => 'ProductCategoryController@index',
        'middleware' => 'can:icommerce.productcategories.index'
    ]);
    $router->get('productcategories/create', [
        'as' => 'admin.icommerce.productcategory.create',
        'uses' => 'ProductCategoryController@create',
        'middleware' => 'can:icommerce.productcategories.create'
    ]);
    $router->post('productcategories', [
        'as' => 'admin.icommerce.productcategory.store',
        'uses' => 'ProductCategoryController@store',
        'middleware' => 'can:icommerce.productcategories.create'
    ]);
    $router->get('productcategories/{productcategory}/edit', [
        'as' => 'admin.icommerce.productcategory.edit',
        'uses' => 'ProductCategoryController@edit',
        'middleware' => 'can:icommerce.productcategories.edit'
    ]);
    $router->put('productcategories/{productcategory}', [
        'as' => 'admin.icommerce.productcategory.update',
        'uses' => 'ProductCategoryController@update',
        'middleware' => 'can:icommerce.productcategories.edit'
    ]);
    $router->delete('productcategories/{productcategory}', [
        'as' => 'admin.icommerce.productcategory.destroy',
        'uses' => 'ProductCategoryController@destroy',
        'middleware' => 'can:icommerce.productcategories.destroy'
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
    $router->bind('shippingcourier', function ($id) {
        return app('Modules\Icommerce\Repositories\ShippingCourierRepository')->find($id);
    });
    $router->get('shippingcouriers', [
        'as' => 'admin.icommerce.shippingcourier.index',
        'uses' => 'ShippingCourierController@index',
        'middleware' => 'can:icommerce.shippingcouriers.index'
    ]);
    $router->get('shippingcouriers/create', [
        'as' => 'admin.icommerce.shippingcourier.create',
        'uses' => 'ShippingCourierController@create',
        'middleware' => 'can:icommerce.shippingcouriers.create'
    ]);
    $router->post('shippingcouriers', [
        'as' => 'admin.icommerce.shippingcourier.store',
        'uses' => 'ShippingCourierController@store',
        'middleware' => 'can:icommerce.shippingcouriers.create'
    ]);
    $router->get('shippingcouriers/{shippingcourier}/edit', [
        'as' => 'admin.icommerce.shippingcourier.edit',
        'uses' => 'ShippingCourierController@edit',
        'middleware' => 'can:icommerce.shippingcouriers.edit'
    ]);
    $router->put('shippingcouriers/{shippingcourier}', [
        'as' => 'admin.icommerce.shippingcourier.update',
        'uses' => 'ShippingCourierController@update',
        'middleware' => 'can:icommerce.shippingcouriers.edit'
    ]);
    $router->delete('shippingcouriers/{shippingcourier}', [
        'as' => 'admin.icommerce.shippingcourier.destroy',
        'uses' => 'ShippingCourierController@destroy',
        'middleware' => 'can:icommerce.shippingcouriers.destroy'
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
    $router->bind('orderproduct', function ($id) {
        return app('Modules\Icommerce\Repositories\OrderProductRepository')->find($id);
    });
    $router->get('orderproducts', [
        'as' => 'admin.icommerce.orderproduct.index',
        'uses' => 'OrderProductController@index',
        'middleware' => 'can:icommerce.orderproducts.index'
    ]);
    $router->get('orderproducts/create', [
        'as' => 'admin.icommerce.orderproduct.create',
        'uses' => 'OrderProductController@create',
        'middleware' => 'can:icommerce.orderproducts.create'
    ]);
    $router->post('orderproducts', [
        'as' => 'admin.icommerce.orderproduct.store',
        'uses' => 'OrderProductController@store',
        'middleware' => 'can:icommerce.orderproducts.create'
    ]);
    $router->get('orderproducts/{orderproduct}/edit', [
        'as' => 'admin.icommerce.orderproduct.edit',
        'uses' => 'OrderProductController@edit',
        'middleware' => 'can:icommerce.orderproducts.edit'
    ]);
    $router->put('orderproducts/{orderproduct}', [
        'as' => 'admin.icommerce.orderproduct.update',
        'uses' => 'OrderProductController@update',
        'middleware' => 'can:icommerce.orderproducts.edit'
    ]);
    $router->delete('orderproducts/{orderproduct}', [
        'as' => 'admin.icommerce.orderproduct.destroy',
        'uses' => 'OrderProductController@destroy',
        'middleware' => 'can:icommerce.orderproducts.destroy'
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
    $router->bind('ordershipment', function ($id) {
        return app('Modules\Icommerce\Repositories\OrderShipmentRepository')->find($id);
    });
    $router->get('ordershipments', [
        'as' => 'admin.icommerce.ordershipment.index',
        'uses' => 'OrderShipmentController@index',
        'middleware' => 'can:icommerce.ordershipments.index'
    ]);
    $router->get('ordershipments/create', [
        'as' => 'admin.icommerce.ordershipment.create',
        'uses' => 'OrderShipmentController@create',
        'middleware' => 'can:icommerce.ordershipments.create'
    ]);
    $router->post('ordershipments', [
        'as' => 'admin.icommerce.ordershipment.store',
        'uses' => 'OrderShipmentController@store',
        'middleware' => 'can:icommerce.ordershipments.create'
    ]);
    $router->get('ordershipments/{ordershipment}/edit', [
        'as' => 'admin.icommerce.ordershipment.edit',
        'uses' => 'OrderShipmentController@edit',
        'middleware' => 'can:icommerce.ordershipments.edit'
    ]);
    $router->put('ordershipments/{ordershipment}', [
        'as' => 'admin.icommerce.ordershipment.update',
        'uses' => 'OrderShipmentController@update',
        'middleware' => 'can:icommerce.ordershipments.edit'
    ]);
    $router->delete('ordershipments/{ordershipment}', [
        'as' => 'admin.icommerce.ordershipment.destroy',
        'uses' => 'OrderShipmentController@destroy',
        'middleware' => 'can:icommerce.ordershipments.destroy'
    ]);
    $router->bind('couponcategory', function ($id) {
        return app('Modules\Icommerce\Repositories\CouponCategoryRepository')->find($id);
    });
    $router->get('couponcategories', [
        'as' => 'admin.icommerce.couponcategory.index',
        'uses' => 'CouponCategoryController@index',
        'middleware' => 'can:icommerce.couponcategories.index'
    ]);
    $router->get('couponcategories/create', [
        'as' => 'admin.icommerce.couponcategory.create',
        'uses' => 'CouponCategoryController@create',
        'middleware' => 'can:icommerce.couponcategories.create'
    ]);
    $router->post('couponcategories', [
        'as' => 'admin.icommerce.couponcategory.store',
        'uses' => 'CouponCategoryController@store',
        'middleware' => 'can:icommerce.couponcategories.create'
    ]);
    $router->get('couponcategories/{couponcategory}/edit', [
        'as' => 'admin.icommerce.couponcategory.edit',
        'uses' => 'CouponCategoryController@edit',
        'middleware' => 'can:icommerce.couponcategories.edit'
    ]);
    $router->put('couponcategories/{couponcategory}', [
        'as' => 'admin.icommerce.couponcategory.update',
        'uses' => 'CouponCategoryController@update',
        'middleware' => 'can:icommerce.couponcategories.edit'
    ]);
    $router->delete('couponcategories/{couponcategory}', [
        'as' => 'admin.icommerce.couponcategory.destroy',
        'uses' => 'CouponCategoryController@destroy',
        'middleware' => 'can:icommerce.couponcategories.destroy'
    ]);
    $router->bind('couponproduct', function ($id) {
        return app('Modules\Icommerce\Repositories\CouponProductRepository')->find($id);
    });
    $router->get('couponproducts', [
        'as' => 'admin.icommerce.couponproduct.index',
        'uses' => 'CouponProductController@index',
        'middleware' => 'can:icommerce.couponproducts.index'
    ]);
    $router->get('couponproducts/create', [
        'as' => 'admin.icommerce.couponproduct.create',
        'uses' => 'CouponProductController@create',
        'middleware' => 'can:icommerce.couponproducts.create'
    ]);
    $router->post('couponproducts', [
        'as' => 'admin.icommerce.couponproduct.store',
        'uses' => 'CouponProductController@store',
        'middleware' => 'can:icommerce.couponproducts.create'
    ]);
    $router->get('couponproducts/{couponproduct}/edit', [
        'as' => 'admin.icommerce.couponproduct.edit',
        'uses' => 'CouponProductController@edit',
        'middleware' => 'can:icommerce.couponproducts.edit'
    ]);
    $router->put('couponproducts/{couponproduct}', [
        'as' => 'admin.icommerce.couponproduct.update',
        'uses' => 'CouponProductController@update',
        'middleware' => 'can:icommerce.couponproducts.edit'
    ]);
    $router->delete('couponproducts/{couponproduct}', [
        'as' => 'admin.icommerce.couponproduct.destroy',
        'uses' => 'CouponProductController@destroy',
        'middleware' => 'can:icommerce.couponproducts.destroy'
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
    $router->bind('payment', function ($id) {
        return app('Modules\Icommerce\Repositories\TransactionRepository')->find($id);
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
    $router->bind('relatedproduct', function ($id) {
        return app('Modules\Icommerce\Repositories\RelatedProductRepository')->find($id);
    });
    $router->get('relatedproducts', [
        'as' => 'admin.icommerce.relatedproduct.index',
        'uses' => 'RelatedProductController@index',
        'middleware' => 'can:icommerce.relatedproducts.index'
    ]);
    $router->get('relatedproducts/create', [
        'as' => 'admin.icommerce.relatedproduct.create',
        'uses' => 'RelatedProductController@create',
        'middleware' => 'can:icommerce.relatedproducts.create'
    ]);
    $router->post('relatedproducts', [
        'as' => 'admin.icommerce.relatedproduct.store',
        'uses' => 'RelatedProductController@store',
        'middleware' => 'can:icommerce.relatedproducts.create'
    ]);
    $router->get('relatedproducts/{relatedproduct}/edit', [
        'as' => 'admin.icommerce.relatedproduct.edit',
        'uses' => 'RelatedProductController@edit',
        'middleware' => 'can:icommerce.relatedproducts.edit'
    ]);
    $router->put('relatedproducts/{relatedproduct}', [
        'as' => 'admin.icommerce.relatedproduct.update',
        'uses' => 'RelatedProductController@update',
        'middleware' => 'can:icommerce.relatedproducts.edit'
    ]);
    $router->delete('relatedproducts/{relatedproduct}', [
        'as' => 'admin.icommerce.relatedproduct.destroy',
        'uses' => 'RelatedProductController@destroy',
        'middleware' => 'can:icommerce.relatedproducts.destroy'
    ]);
    $router->bind('list', function ($id) {
        return app('Modules\Icommerce\Repositories\ListRepository')->find($id);
    });
    $router->get('lists', [
        'as' => 'admin.icommerce.list.index',
        'uses' => 'ListController@index',
        'middleware' => 'can:icommerce.lists.index'
    ]);
    $router->get('lists/create', [
        'as' => 'admin.icommerce.list.create',
        'uses' => 'ListController@create',
        'middleware' => 'can:icommerce.lists.create'
    ]);
    $router->post('lists', [
        'as' => 'admin.icommerce.list.store',
        'uses' => 'ListController@store',
        'middleware' => 'can:icommerce.lists.create'
    ]);
    $router->get('lists/{list}/edit', [
        'as' => 'admin.icommerce.list.edit',
        'uses' => 'ListController@edit',
        'middleware' => 'can:icommerce.lists.edit'
    ]);
    $router->put('lists/{list}', [
        'as' => 'admin.icommerce.list.update',
        'uses' => 'ListController@update',
        'middleware' => 'can:icommerce.lists.edit'
    ]);
    $router->delete('lists/{list}', [
        'as' => 'admin.icommerce.list.destroy',
        'uses' => 'ListController@destroy',
        'middleware' => 'can:icommerce.lists.destroy'
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
    $router->bind('cartproductoption', function ($id) {
        return app('Modules\Icommerce\Repositories\CartProductOptionRepository')->find($id);
    });
    $router->get('cartproductoptions', [
        'as' => 'admin.icommerce.cartproductoption.index',
        'uses' => 'CartProductOptionController@index',
        'middleware' => 'can:icommerce.cartproductoptions.index'
    ]);
    $router->get('cartproductoptions/create', [
        'as' => 'admin.icommerce.cartproductoption.create',
        'uses' => 'CartProductOptionController@create',
        'middleware' => 'can:icommerce.cartproductoptions.create'
    ]);
    $router->post('cartproductoptions', [
        'as' => 'admin.icommerce.cartproductoption.store',
        'uses' => 'CartProductOptionController@store',
        'middleware' => 'can:icommerce.cartproductoptions.create'
    ]);
    $router->get('cartproductoptions/{cartproductoption}/edit', [
        'as' => 'admin.icommerce.cartproductoption.edit',
        'uses' => 'CartProductOptionController@edit',
        'middleware' => 'can:icommerce.cartproductoptions.edit'
    ]);
    $router->put('cartproductoptions/{cartproductoption}', [
        'as' => 'admin.icommerce.cartproductoption.update',
        'uses' => 'CartProductOptionController@update',
        'middleware' => 'can:icommerce.cartproductoptions.edit'
    ]);
    $router->delete('cartproductoptions/{cartproductoption}', [
        'as' => 'admin.icommerce.cartproductoption.destroy',
        'uses' => 'CartProductOptionController@destroy',
        'middleware' => 'can:icommerce.cartproductoptions.destroy'
    ]);
// append


































});
