<?php

return [
  'admin' => [
    "products" => [
      "permission" => "icommerce.products.manage",
      "activated" => true,
      "path" => "/ecommerce/products",
      "name" => "qcommerce.admin.products.index",
      "crud" => "qcommerce/_crud/products",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminProducts",
      "icon" => "fas fa-boxes",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "productCreate" => [
      "permission" => "icommerce.products.create",
      "activated" => true,
      "path" => "/ecommerce/products/create",
      "name" => "qcommerce.admin.products.create",
      "page" => "qcommerce/_pages/admin/products/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminProductCreate",
      "icon" => "fas fa-boxes",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.products"
        ],
        "recommendations" => [
          "name" => "commerceProduct"
        ]
      ]
    ],
    "productEdit" => [
      "permission" => "icommerce.products.edit",
      "activated" => true,
      "path" => "/ecommerce/products/:id",
      "name" => "qcommerce.admin.products.edit",
      "page" => "qcommerce/_pages/admin/products/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminProductEdit",
      "icon" => "fas fa-boxes",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.products"
        ],
        "recommendations" => [
          "name" => "commerceProduct"
        ]
      ]
    ],
    "categories" => [
      "permission" => "icommerce.categories.manage",
      "activated" => true,
      "path" => "/ecommerce/product-categories",
      "name" => "qcommerce.admin.categories",
      "crud" => "qcommerce/_crud/productCategories",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminCategories",
      "icon" => "fas fa-layer-group",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.products"
        ]
      ]
    ],
    "options" => [
      "permission" => "icommerce.options.manage",
      "activated" => true,
      "path" => "/ecommerce/product-options",
      "name" => "qcommerce.admin.options",
      "crud" => "qcommerce/_crud/productOptions",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminOptions",
      "icon" => "fas fa-cogs",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.products"
        ]
      ]
    ],
    "optionsEdit" => [
      "permission" => "icommerce.options.edit",
      "activated" => true,
      "path" => "/ecommerce/product-options/:id",
      "name" => "qcommerce.admin.options.edit",
      "page" => "qcommerce/_pages/admin/option/show",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminOptionsEdit",
      "icon" => "fas fa-cogs",
      "authenticated" => true
    ],
    "optionValues" => [
      "permission" => "icommerce.optionvalues.index",
      "activated" => true,
      "path" => "/ecommerce/product-options-values",
      "name" => "qcommerce.admin.options.values",
      "page" => "qcommerce/_pages/admin/optionValues/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminValues",
      "icon" => "fas fa-stream",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.products",
          "qcommerce.options"
        ]
      ]
    ],
    "optionValuesCreate" => [
      "permission" => "icommerce.optionvalues.create",
      "activated" => true,
      "path" => "/ecommerce/product-options/values/:optionId",
      "name" => "qcommerce.admin.optionValues.create",
      "page" => "qcommerce/_pages/admin/optionValues/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminValuesCreate",
      "icon" => "fas fa-stream",
      "authenticated" => true
    ],
    "optionValuesUpdate" => [
      "permission" => "icommerce.optionvalues.update",
      "activated" => true,
      "path" => "/ecommerce/product-options/:optionId/value/:id",
      "name" => "qcommerce.admin.optionValues.update",
      "page" => "qcommerce/_pages/admin/optionValues/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminValuesEdit",
      "icon" => "fas fa-stream",
      "authenticated" => true
    ],
    "paymentMethods" => [
      "permission" => "icommerce.payment-methods.manage",
      "activated" => true,
      "path" => "/payment-methods",
      "name" => "qcommerce.admin.payment.methods",
      "crud" => "qcommerce/_crud/paymentMethods",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminPaymentMethods",
      "icon" => "fas fa-money-bill-wave",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "shippingMethods" => [
      "permission" => "icommerce.shipping-methods.manage",
      "activated" => true,
      "path" => "/shipping-methods",
      "name" => "qcommerce.admin.shipping.methods",
      "crud" => "qcommerce/_crud/shippingMethods",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminShippingMethods",
      "icon" => "fas fa-shipping-fast",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "orders" => [
      "permission" => "icommerce.orders.manage",
      "activated" => true,
      "path" => "/orders",
      "name" => "qcommerce.admin.shipping.orders.index",
      "crud" => "qcommerce/_crud/orders",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminOrders",
      "icon" => "fas fa-box-open",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "order" => [
      "permission" => "icommerce.orders.index",
      "activated" => true,
      "path" => "/order/:id",
      "name" => "qcommerce.shipping.orders.show",
      "page" => "qcommerce/_pages/admin/order/show",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.orderIndex",
      "icon" => "fas fa-box-open",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.orders"
        ]
      ]
    ],
    "stores" => [
      "permission" => "icommerce.stores.index",
      "activated" => true,
      "path" => "/ecommerce/stores",
      "name" => "qcommerce.admin.stores",
      "page" => "qcommerce/_pages/admin/store/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminStores",
      "icon" => "fas fa-store",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "manufacturers" => [
      "permission" => "icommerce.manufacturers.manage",
      "activated" => true,
      "path" => "/ecommerce/manufacturers",
      "name" => "qcommerce.admin.manufacturers",
      "crud" => "qcommerce/_crud/manufacturers",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminManufacturers",
      "icon" => "fas fa-industry",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "taxClasses" => [
      "permission" => "icommerce.taxclasses.manage",
      "activated" => true,
      "path" => "/ecommerce/tax-classes",
      "name" => "qcommerce.admin.taxClasses",
      "page" => "qcommerce/_pages/admin/taxClass/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminTaxes",
      "icon" => "fas fa-percentage",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "taxClassCreate" => [
      "permission" => "icommerce.taxclasses.create",
      "activated" => true,
      "path" => "/ecommerce/tax-classes/create",
      "name" => "qcommerce.admin.taxClasses.create",
      "page" => "qcommerce/_pages/admin/taxClass/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminTaxClassesCreate",
      "icon" => "fas fa-percentage",
      "authenticated" => true
    ],
    "taxClassEdit" => [
      "permission" => "icommerce.taxclasses.edit",
      "activated" => true,
      "path" => "/ecommerce/tax-classes/:id",
      "name" => "qcommerce.admin.taxClasses.edit",
      "page" => "qcommerce/_pages/admin/taxClass/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminTaxClassesEdit",
      "icon" => "fas fa-percentage",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "taxRates" => [
      "permission" => "icommerce.taxrates.manage",
      "activated" => true,
      "path" => "/ecommerce/tax-rates",
      "name" => "qcommerce.admin.taxRates",
      "page" => "qcommerce/_pages/admin/taxRate/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminTaxRates",
      "icon" => "fas fa-percentage",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "coupons" => [
      "permission" => "icommerce.coupons.manage",
      "activated" => true,
      "path" => "/coupons",
      "name" => "qcommerce.admin.coupons.index",
      "page" => "qcommerce/_pages/admin/coupons/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminCoupons",
      "icon" => "fas fa-ticket-alt",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "couponsCreate" => [
      "permission" => "icommerce.coupons.create",
      "activated" => true,
      "path" => "/coupons/create",
      "name" => "qcommerce.admin.coupons.create",
      "page" => "qcommerce/_pages/admin/coupons/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.createCoupons",
      "icon" => "fas fa-ticket-alt",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.coupons"
        ]
      ]
    ],
    "couponsEdit" => [
      "permission" => "icommerce.coupons.edit",
      "activated" => true,
      "path" => "/coupons/:id",
      "name" => "qcommerce.admin.coupons.edit",
      "page" => "qcommerce/_pages/admin/coupons/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.editCoupons",
      "icon" => "fas fa-ticket-alt",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.coupons"
        ]
      ]
    ],
    "priceLists" => [
      "permission" => "icommercepricelist.pricelists.manage",
      "activated" => true,
      "path" => "/priceLists",
      "name" => "qcommerce.admin.priceLists.index",
      "crud" => "qcommerce/_crud/priceLists",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminPriceLists",
      "icon" => "fas fa-dollar-sign",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "itemTypes" => [
      "permission" => "icommerce.itemtypes.manage",
      "activated" => true,
      "path" => "/itemTypes",
      "name" => "qcommerce.admin.itemTypes.index",
      "crud" => "qcommerce/_crud/itemTypes",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminItemTypes",
      "icon" => "fas fa-list",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "currency" => [
      "permission" => "icommerce.currencies.manage",
      "activated" => true,
      "path" => "/ecommerce/currencies",
      "name" => "qcommerce.admin.currencies.index",
      "crud" => "qcommerce/_crud/currencies",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.currencies",
      "icon" => "fas fa-donate",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "quotes" => [
      "permission" => "icommerce.quotes.manage",
      "activated" => true,
      "path" => "/icommerce/quotes",
      "name" => "qcommerce.admin.quotes.index",
      "crud" => "qcommerce/_crud/quotes",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminQuotes",
      "icon" => "fas fa-file-invoice-dollar",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "quoteCreate" => [
      "permission" => "icommerce.quotes.create",
      "activated" => true,
      "path" => "/icommerce/quotes/create",
      "name" => "qcommerce.admin.quotes.create",
      "page" => "qcommerce/_pages/admin/quotes/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icommerce.cms.sidebar.adminQuoteCreate",
      "icon" => "fas fa-file-invoice-dollar",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.quotes"
        ]
      ]
    ]
  ],
  'panel' => [
    "orders" => [
      "permission" => "icommerce.orders.manage",
      "activated" => true,
      "path" => "/store/orders",
      "name" => "qcommerce.panel.shipping.orders.index",
      "crud" => "qcommerce/_crud/orders",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master",
      "title" => "icommerce.cms.sidebar.panelOrders",
      "icon" => "fas fa-shopping-bag",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "order" => [
      "permission" => "icommerce.orders.index",
      "activated" => true,
      "path" => "/store/orders/:id",
      "name" => "qcommerce.shipping.orders.show",
      "page" => "qcommerce/_pages/admin/order/show",
      "layout" => "qsite/_layouts/master",
      "title" => "icommerce.cms.sidebar.orderIndex",
      "icon" => "fas fa-box-open",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "qcommerce.orders"
        ]
      ]
    ]
  ],
  'main' => []
];
