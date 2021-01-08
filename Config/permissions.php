<?php

return [
    'icommerce.tags' => [
        'index' => 'icommerce::tags.list resource',
        'create' => 'icommerce::tags.create resource',
        'edit' => 'icommerce::tags.edit resource',
        'destroy' => 'icommerce::tags.destroy resource',
    ],
    'icommerce.categories' => [
        'index' => 'icommerce::categories.list resource',
        'create' => 'icommerce::categories.create resource',
        'edit' => 'icommerce::categories.edit resource',
        'destroy' => 'icommerce::categories.destroy resource',
    ],
    'icommerce.manufacturers' => [
        'index' => 'icommerce::manufacturers.list resource',
        'create' => 'icommerce::manufacturers.create resource',
        'edit' => 'icommerce::manufacturers.edit resource',
        'destroy' => 'icommerce::manufacturers.destroy resource',
    ],
    'icommerce.products' => [
        'index' => 'icommerce::products.list resource',
        'create' => 'icommerce::products.create resource',
        'edit' => 'icommerce::products.edit resource',
        'destroy' => 'icommerce::products.destroy resource',
    ],
    'icommerce.bulkload' => [
        'import' => 'icommerce::bulkload.import',
        'export' => 'icommerce::bulkload.import',
    ],
    'icommerce.producttags' => [
        'index' => 'icommerce::producttags.list resource',
        'create' => 'icommerce::producttags.create resource',
        'edit' => 'icommerce::producttags.edit resource',
        'destroy' => 'icommerce::producttags.destroy resource',
    ],
    'icommerce.productcategories' => [
        'index' => 'icommerce::productcategories.list resource',
        'create' => 'icommerce::productcategories.create resource',
        'edit' => 'icommerce::productcategories.edit resource',
        'destroy' => 'icommerce::productcategories.destroy resource',
    ],
    'icommerce.options' => [
        'index' => 'icommerce::options.list resource',
        'create' => 'icommerce::options.create resource',
        'edit' => 'icommerce::options.edit resource',
        'destroy' => 'icommerce::options.destroy resource',
    ],
    'icommerce.coupons' => [
        'index' => 'icommerce::coupons.list resource',
        'create' => 'icommerce::coupons.create resource',
        'edit' => 'icommerce::coupons.edit resource',
        'destroy' => 'icommerce::coupons.destroy resource',
    ],
    'icommerce.shippingcouriers' => [
        'index' => 'icommerce::shippingcouriers.list resource',
        'create' => 'icommerce::shippingcouriers.create resource',
        'edit' => 'icommerce::shippingcouriers.edit resource',
        'destroy' => 'icommerce::shippingcouriers.destroy resource',
    ],
    'icommerce.currencies' => [
        'index' => 'icommerce::currencies.list resource',
        'create' => 'icommerce::currencies.create resource',
        'edit' => 'icommerce::currencies.edit resource',
        'destroy' => 'icommerce::currencies.destroy resource',
    ],
    'icommerce.orders' => [
      'index' => 'icommerce::orders.list resource',
      'index-all' => 'icommerce::orders.list-all resource',
      'show' => 'icommerce::orders.show resource',
      'show-others' => 'icommerce::orders.show-others resource',
        'create' => 'icommerce::orders.create resource',
        'edit' => 'icommerce::orders.edit resource',
        'destroy' => 'icommerce::orders.destroy resource',
    ],
    'icommerce.productdiscounts' => [
        'index' => 'icommerce::productdiscounts.list resource',
        'create' => 'icommerce::productdiscounts.create resource',
        'edit' => 'icommerce::productdiscounts.edit resource',
        'destroy' => 'icommerce::productdiscounts.destroy resource',
    ],
    'icommerce.optionvalues' => [
        'index' => 'icommerce::optionvalues.list resource',
        'create' => 'icommerce::optionvalues.create resource',
        'edit' => 'icommerce::optionvalues.edit resource',
        'destroy' => 'icommerce::optionvalues.destroy resource',
    ],
    'icommerce.productoptions' => [
        'index' => 'icommerce::productoptions.list resource',
        'create' => 'icommerce::productoptions.create resource',
        'edit' => 'icommerce::productoptions.edit resource',
        'destroy' => 'icommerce::productoptions.destroy resource',
    ],
    'icommerce.productoptionvalues' => [
        'index' => 'icommerce::productoptionvalues.list resource',
        'create' => 'icommerce::productoptionvalues.create resource',
        'edit' => 'icommerce::productoptionvalues.edit resource',
        'destroy' => 'icommerce::productoptionvalues.destroy resource',
    ],
    'icommerce.orderproducts' => [
        'index' => 'icommerce::orderproducts.list resource',
        'create' => 'icommerce::orderproducts.create resource',
        'edit' => 'icommerce::orderproducts.edit resource',
        'destroy' => 'icommerce::orderproducts.destroy resource',
    ],
    'icommerce.orderoptions' => [
        'index' => 'icommerce::orderoptions.list resource',
        'create' => 'icommerce::orderoptions.create resource',
        'edit' => 'icommerce::orderoptions.edit resource',
        'destroy' => 'icommerce::orderoptions.destroy resource',
    ],
    'icommerce.orderhistories' => [
        'index' => 'icommerce::orderhistories.list resource',
        'create' => 'icommerce::orderhistories.create resource',
        'edit' => 'icommerce::orderhistories.edit resource',
        'destroy' => 'icommerce::orderhistories.destroy resource',
    ],
    'icommerce.ordershipments' => [
        'index' => 'icommerce::ordershipments.list resource',
        'create' => 'icommerce::ordershipments.create resource',
        'edit' => 'icommerce::ordershipments.edit resource',
        'destroy' => 'icommerce::ordershipments.destroy resource',
    ],
    'icommerce.couponcategories' => [
        'index' => 'icommerce::couponcategories.list resource',
        'create' => 'icommerce::couponcategories.create resource',
        'edit' => 'icommerce::couponcategories.edit resource',
        'destroy' => 'icommerce::couponcategories.destroy resource',
    ],
    'icommerce.couponproducts' => [
        'index' => 'icommerce::couponproducts.list resource',
        'create' => 'icommerce::couponproducts.create resource',
        'edit' => 'icommerce::couponproducts.edit resource',
        'destroy' => 'icommerce::couponproducts.destroy resource',
    ],
    'icommerce.couponhistories' => [
        'index' => 'icommerce::couponhistories.list resource',
        'create' => 'icommerce::couponhistories.create resource',
        'edit' => 'icommerce::couponhistories.edit resource',
        'destroy' => 'icommerce::couponhistories.destroy resource',
    ],
    'icommerce.wishlists' => [
        'index' => 'icommerce::wishlists.list resource',
        'create' => 'icommerce::wishlists.create resource',
        'edit' => 'icommerce::wishlists.edit resource',
        'destroy' => 'icommerce::wishlists.destroy resource',
    ],
    'icommerce.payments' => [
        'index' => 'icommerce::payments.list resource',
        'create' => 'icommerce::payments.create resource',
        'edit' => 'icommerce::payments.edit resource',
        'destroy' => 'icommerce::payments.destroy resource',
    ],
    'icommerce.shippings' => [
        'index' => 'icommerce::shippings.list resource',
        'create' => 'icommerce::shippings.create resource',
        'edit' => 'icommerce::shippings.edit resource',
        'destroy' => 'icommerce::shippings.destroy resource',
    ],
    'icommerce.taxrates' => [
        'index' => 'icommerce::taxrates.list resource',
        'create' => 'icommerce::taxrates.create resource',
        'edit' => 'icommerce::taxrates.edit resource',
        'destroy' => 'icommerce::taxrates.destroy resource',
    ],
    'icommerce.taxclasses' => [
        'index' => 'icommerce::taxclasses.list resource',
        'create' => 'icommerce::taxclasses.create resource',
        'edit' => 'icommerce::taxclasses.edit resource',
        'destroy' => 'icommerce::taxclasses.destroy resource',
    ],
    'icommerce.taxclassrates' => [
        'index' => 'icommerce::taxclassrates.list resource',
        'create' => 'icommerce::taxclassrates.create resource',
        'edit' => 'icommerce::taxclassrates.edit resource',
        'destroy' => 'icommerce::taxclassrates.destroy resource',
    ],
    'icommerce.itemtypes' => [
        'index' => 'icommerce::itemtypes.list resource',
        'create' => 'icommerce::itemtypes.create resource',
        'edit' => 'icommerce::itemtypes.edit resource',
        'destroy' => 'icommerce::itemtypes.destroy resource',
    ],
    'icommerce.relatedproducts' => [
        'index' => 'icommerce::relatedproducts.list resource',
        'create' => 'icommerce::relatedproducts.create resource',
        'edit' => 'icommerce::relatedproducts.edit resource',
        'destroy' => 'icommerce::relatedproducts.destroy resource',
    ],
    'icommerce.lists' => [
        'index' => 'icommerce::lists.list resource',
        'create' => 'icommerce::lists.create resource',
        'edit' => 'icommerce::lists.edit resource',
        'destroy' => 'icommerce::lists.destroy resource',
    ],
    'icommerce.productlists' => [
        'manage' => 'icommerce::productlists.manage resource',
        'index' => 'icommerce::productlists.list resource',
        'create' => 'icommerce::productlists.create resource',
        'edit' => 'icommerce::productlists.edit resource',
        'destroy' => 'icommerce::productlists.destroy resource',
    ],
    'icommerce.payment-methods' => [
        'manage' => 'icommerce::paymentmethods.manage resource',
        'index' => 'icommerce::paymentmethods.list resource',
        'create' => 'icommerce::paymentmethods.create resource',
        'edit' => 'icommerce::paymentmethods.edit resource',
        'destroy' => 'icommerce::paymentmethods.destroy resource',
    ],
    'icommerce.cartproductoptions' => [
        'index' => 'icommerce::cartproductoptions.list resource',
        'create' => 'icommerce::cartproductoptions.create resource',
        'edit' => 'icommerce::cartproductoptions.edit resource',
        'destroy' => 'icommerce::cartproductoptions.destroy resource',
    ],
    'icommerce.shipping-methods' => [
        'manage' => 'icommerce::shippingmethods.manage resource',
        'index' => 'icommerce::shippingmethods.list resource',
        'create' => 'icommerce::shippingmethods.create resource',
        'edit' => 'icommerce::shippingmethods.edit resource',
        'destroy' => 'icommerce::shippingmethods.destroy resource',
    ],
    'icommerce.shippingmethodgeozones' => [
        'index' => 'icommerce::shippingmethodgeozones.list resource',
        'create' => 'icommerce::shippingmethodgeozones.create resource',
        'edit' => 'icommerce::shippingmethodgeozones.edit resource',
        'destroy' => 'icommerce::shippingmethodgeozones.destroy resource',
    ],
    'icommerce.paymentmethodgeozones' => [
        'index' => 'icommerce::paymentmethodgeozones.list resource',
        'create' => 'icommerce::paymentmethodgeozones.create resource',
        'edit' => 'icommerce::paymentmethodgeozones.edit resource',
        'destroy' => 'icommerce::paymentmethodgeozones.destroy resource',
    ],
// append




































];
