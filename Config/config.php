<?php

return [
    'name' => 'Icommerce',
    'frontendModuleName' => 'qcommerce',

    /*
   |--------------------------------------------------------------------------
   | Default layout for the notification module
   |--------------------------------------------------------------------------
   */
    'defaultEmailLayout' => 'notification::emails.layouts.default',

    /*
   |--------------------------------------------------------------------------
   | Default content layout in the notification module
   |--------------------------------------------------------------------------
   */
    'defaultEmailContent' => 'notification::emails.contents.default',

    /*
   |--------------------------------------------------------------------------
   | Order Statuses to seed in the order status table
   |--------------------------------------------------------------------------
   */
    'orderStatuses' => [
        '1' => [
            'id' => 1,
            'title' => 'icommerce::orderstatuses.statuses.pending',
        ],
        '2' => [
            'id' => 2,
            'title' => 'icommerce::orderstatuses.statuses.shipped',
        ],
        '3' => [
            'id' => 3,
            'title' => 'icommerce::orderstatuses.statuses.canceled',
        ],
        '4' => [
            'id' => 4,
            'title' => 'icommerce::orderstatuses.statuses.completed',
        ],
        '5' => [
            'id' => 5,
            'title' => 'icommerce::orderstatuses.statuses.denied',
        ],
        '6' => [
            'id' => 6,
            'title' => 'icommerce::orderstatuses.statuses.canceledreversal',
        ],
        '7' => [
            'id' => 7,
            'title' => 'icommerce::orderstatuses.statuses.failed',
        ],
        '8' => [
            'id' => 8,
            'title' => 'icommerce::orderstatuses.statuses.refunded',
        ],
        '9' => [
            'id' => 9,
            'title' => 'icommerce::orderstatuses.statuses.reserved',
        ],
        '10' => [
            'id' => 10,
            'title' => 'icommerce::orderstatuses.statuses.chargeback',
        ],
        '11' => [
            'id' => 11,
            'title' => 'icommerce::orderstatuses.statuses.confirmingPayment',
        ],
        '12' => [
            'id' => 12,
            'title' => 'icommerce::orderstatuses.statuses.voided',
        ],
        '13' => [
            'id' => 13,
            'title' => 'icommerce::orderstatuses.statuses.processed',
        ],
        '14' => [
            'id' => 14,
            'title' => 'icommerce::orderstatuses.statuses.expired',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Define routes to sites with old routes
   |--------------------------------------------------------------------------
   */
    'useOldRoutes' => false,

    /*
   |--------------------------------------------------------------------------
   | Define the default product rating
   |--------------------------------------------------------------------------
   */
    'defaultProductRating' => 5,

    /*
   |--------------------------------------------------------------------------
   | Define the different item types to the products
   |--------------------------------------------------------------------------
   */
    'itemTypes' => [
        '1' => [
            'id' => 1,
            'title' => 'icommerce::itemtypes.types.product',
        ],
        '2' => [
            'id' => 2,
            'title' => 'icommerce::itemtypes.types.service',
        ],
        '3' => [
            'id' => 3,
            'title' => 'icommerce::itemtypes.types.other',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Define format money to the product price frontend
   |--------------------------------------------------------------------------
   */
    'formatmoney' => [
        'symbol_left' => '$',
        'symbol_right' => '',
        'decimals' => 0,
        'decimal_separator' => '.',
        'thousands_separator' => ',',
        'code' => 'USD',
        'value' => 1,
    ],

    /*
   |--------------------------------------------------------------------------
   | add: custom product includes
   | (if they are empty icommerce module will be using default includes) (slim)
   |--------------------------------------------------------------------------
   */
    'includes' => [
        'product' => [
            /*'posts' => [
        'path' => 'Modules\Iblog\Transformers\PostTransformer', //this is the transformer path
        'multiple' => true, //if is one-to-many, multiple must be set to true
      ],*/
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | add: product relations like users relations style
   |--------------------------------------------------------------------------
   */
    'relations' => [

        'product' => [
            //This is an productable relation. This relation must have same index as much as "productable product" crud field is called
            /*'posts' => function(){
            return $this->morphedByMany(Modules\Iblog\Entities\Post::class, 'productable','icommerce__productable', 'product_id', 'productable_id');
      }*/
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Define config to the mediaFillable trait for each entity
   |--------------------------------------------------------------------------
   */
    'mediaFillable' => [
        'category' => [
            'mainimage' => 'single',
            'secondaryimage' => 'single',
            'quaternaryimage' => 'single',
            'iconimage' => 'single',
            'bannerindeximage' => 'single',
            'carouselindeximage' => 'multiple',
            'carouseltopindeximages' => 'multiple',
        ],
        'manufacturer' => [
            'mainimage' => 'single',
            'secondaryimage' => 'single',
            'tertiaryimage' => 'single',
            'quaternaryimage' => 'single',
            'carouseltopindeximages' => 'multiple',
        ],
        'paymentmethod' => [
            'mainimage' => 'single',
            'secondaryimage' => 'single',
        ],
        'shippingmethod' => [
            'mainimage' => 'single',
            'secondaryimage' => 'single',
        ],
        'optionvalue' => [
            'mainimage' => 'single',
            'secondaryimage' => 'single',
        ],
        'product' => [
            'mainimage' => 'single',
            'gallery' => 'multiple',
            'secondaryimage' => 'single',
            'quaternaryimage' => 'single',
        ],
    ],

    /*
 |--------------------------------------------------------------------------
 | Define config to the orderBy in the index page
 |--------------------------------------------------------------------------
 */
    'orderBy' => [
        'default' => 'recently',
        'options' => [
            'nameaz' => [
                'title' => 'icommerce::common.sort.name_a_z',
                'name' => 'nameaz',
                'order' => [
                    'field' => 'name',
                    'way' => 'asc',
                ],
            ],
            'nameza' => [
                'title' => 'icommerce::common.sort.name_z_a',
                'name' => 'nameza',
                'order' => [
                    'field' => 'name',
                    'way' => 'desc',
                ],
            ],
            'lowerprice' => [
                'title' => 'icommerce::common.sort.price_low_high',
                'name' => 'lowerprice',
                'order' => [
                    'field' => 'price',
                    'way' => 'asc',
                ],
            ],
            'higherprice' => [
                'title' => 'icommerce::common.sort.price_high_low',
                'name' => 'higherprice',
                'order' => [
                    'field' => 'price',
                    'way' => 'desc',
                ],
            ],
            'recently' => [
                'title' => 'icommerce::common.sort.recently',
                'name' => 'recently',
                'order' => [
                    'field' => 'created_at',
                    'way' => 'desc',
                ],
            ],
        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Layout Products - Index
  |--------------------------------------------------------------------------
  */
    'layoutIndex' => [
        'default' => 'four',
        'options' => [
            'four' => [
                'name' => 'four',
                'class' => 'col-6 col-md-4 col-lg-3',
                'icon' => 'fa fa-th-large',
                'status' => true,
            ],
            'three' => [
                'name' => 'three',
                'class' => 'col-6 col-md-4 col-lg-4',
                'icon' => 'fa fa-square-o',
                'status' => true,
            ],
            'one' => [
                'name' => 'one',
                'class' => 'col-12',
                'icon' => 'fa fa-align-justify',
                'status' => true,
            ],
        ],
    ],

    /*
 |--------------------------------------------------------------------------
 | Livewire Checkout placeOrder click
 |--------------------------------------------------------------------------
 */
    'livewirePlaceOrderClick' => 'submit',
    /*
  |--------------------------------------------------------------------------
  | Custom Includes Before Filters
  |--------------------------------------------------------------------------
  */
    'customIncludesBeforeFilters' => [
        /*
    'manufacturerCard' => [
      'view' => "icommerce.partials.manufacturer-card",
      'show' => ['store','manufacturer','category']
    ]
    */
    ],

    /*
  |--------------------------------------------------------------------------
  | Filters to the index page
  |--------------------------------------------------------------------------
  */
    'filters' => [
        'categories' => [
            'title' => 'icommerce::categories.plural',
            'name' => 'categories',
            /*
       * Types of Title:
       *  itemSelected
       *  titleOfTheConfig - default
       */
            'typeTitle' => 'titleOfTheConfig',
            /*
       * Types of Modes for render:
       *  allTree - default
       *  allFamilyOfTheSelectedNode (Need NodeTrait implemented - laravel-nestedset package)
       *  onlyLeftAndRightOfTheSelectedNode (Need NodeTrait implemented - laravel-nestedset package)
       */
            'renderMode' => 'allTree',
            'status' => true,
            'isExpanded' => true,
            'type' => 'tree',
            'repository' => 'Modules\Icommerce\Repositories\CategoryRepository',
            'entityClass' => 'Modules\Icommerce\Entities\Category',
            'emitTo' => null,
            'repoAction' => null,
            'repoAttribute' => null,
            'listener' => null,
            'repoMethod' => 'getItemsByForTheTreeFilter',
            /*
      * Layouts available:
      *  ttys
      *  alnat
       * default - default
      */
            'layout' => 'default',
            'classes' => 'col-12',
        ],
        'range-prices' => [
            'title' => 'icommerce::common.range.title',
            'name' => 'range-prices',
            'status' => true,
            'isExpanded' => true,
            'type' => 'range',
            'repository' => 'Modules\Icommerce\Repositories\ProductRepository',
            'emitTo' => 'itemsListGetData',
            'repoAction' => 'filter',
            'repoAttribute' => 'priceRange',
            'listener' => 'itemListRendered',
            'repoMethod' => 'getPriceRange',
            'layout' => 'range-layout-1',
            'classes' => 'col-12',
            'step' => 10000,
            'stepSetting' => 'icommerce::filterRangePricesStep',
        ],
        'manufacturers' => [
            'title' => 'icommerce::manufacturers.plural',
            'name' => 'manufacturers',
            'status' => false,
            'isExpanded' => false,
            'type' => 'checkbox',
            'repository' => 'Modules\Icommerce\Repositories\ProductRepository',
            'emitTo' => 'itemsListGetData',
            'repoAction' => 'filter',
            'repoAttribute' => 'manufacturers',
            'listener' => 'itemListRendered',
            'repoMethod' => 'getManufacturers',
            'layout' => 'checkbox-layout-1',
            'classes' => 'col-12',
        ],
        'product-options' => [
            'title' => 'icommerce::productoptions.plural',
            'name' => 'product-options',
            'status' => false,
            'type' => 'checkbox',
            'repository' => 'Modules\Icommerce\Repositories\ProductRepository',
            'emitTo' => 'itemsListGetData',
            'repoAction' => 'filter',
            'repoAttribute' => 'optionValues',
            'listener' => 'itemListRendered',
            'repoMethod' => 'getProductOptions',
            'layout' => 'icommerce::frontend.livewire.index.filters.product-options.index',
            'classes' => 'col-12',
        ],
        'product-types' => [
            'title' => 'icommerce::common.product-type.title',
            'name' => 'product-types',
            'status' => false,
            'isExpanded' => false,
            'options' => [
                'affordable' => [
                    'title' => 'icommerce::common.product-type.affordable',
                    'value' => 0,
                    'status' => true,
                ],
                'searchable' => [
                    'title' => 'icommerce::common.product-type.searchable',
                    'value' => 1,
                    'status' => true,
                ],
            ],
            'type' => 'radio',
            'repository' => 'Modules\Icommerce\Repositories\ProductRepository',
            'emitTo' => 'itemsListGetData',
            'repoAction' => 'filter',
            'repoAttribute' => 'isCall',
            'listener' => 'itemListRendered',
            'repoMethod' => 'getProductTypes',
            'layout' => 'radio-layout-1',
            'classes' => 'col-12',
        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Pagination to the index page
  |--------------------------------------------------------------------------
  */
    'pagination' => [
        'show' => true,
        /*
  * Types of pagination:
  *  normal
  *  loadMore
  *  infiniteScroll
  */
        'type' => 'normal',
    ],

    /*
  |--------------------------------------------------------------------------
  | Custom Includes After Filters
  |--------------------------------------------------------------------------
  */
    'customIncludesAfterFilters' => [
        /*
    'manufacturerCard' => [
      'view' => "icommerce.partials.manufacturer-card",
      'show' => ['manufacturer'] //category, manufacturer
    ]
    */
    ],

    /*
  |--------------------------------------------------------------------------
  | Widgets Components
  |--------------------------------------------------------------------------
  */
    'widgets' => [
        'carousel-vertical' => [
            'component' => 'icommerce::widgets.carousel-vertical',
            'status' => false,
            'id' => 'widgetFeaturedProducts',
            'title' => 'Destacados',
            'isExpanded' => true,
            'props' => [
                'itemsBySlide' => 3,
                'params' => ['filter' => ['featured' => true]],
                'responsive' => [0 => ['items' => 1], 640 => ['items' => 1], 992 => ['items' => 1]],
            ],
        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Extra Footer Partials
  |--------------------------------------------------------------------------
  */
    'extraFooter' => [
        'carouselBestSellers' => [
            'type' => 'owlCarousel',
            'status' => false,
            'id' => 'extraBestSellers',
            'title' => 'Lo que necesitas aqui',
            'subTitle' => 'Los Más Vendidos',
            'props' => [
                'params' => ['filter' => ['featured' => true]],
                'responsive' => [0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 4]],
            ],
        ],
        'customSection' => [
            'type' => 'view',
            'status' => false,
            'id' => 'extraCustom',
            'title' => 'Lo que necesitas aqui',
            'subTitle' => 'Los Más Vendidos',
            'view' => 'icommerce.partials.extra-footer',
        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Define the options to the user menu component
  |
  | @note routeName param must be set without locale. Ex: (icommerce orders: 'icommerce.store.order.index')
  | use **onlyShowInTheDropdownHeader** (boolean) if you want the link only appear in the dropdown in the header
  | use **onlyShowInTheMenuOfTheIndexProfilePage** (boolean) if you want the link only appear in the dropdown in the header
  | use **showInMenuWithoutSession** (boolean) if you want the link only appear in the dropdown when don't exist session
  | use **dispatchModal** (string - modalAlias) if you want the link only appear in the dropdown when don't exist session
  | use **url** (string) if you want customize the link
  |--------------------------------------------------------------------------
  */
    'userMenuLinks' => [
        [
            'title' => 'icommerce::orders.title.orders',
            'routeName' => 'icommerce.store.order.index',
            'quasarUrl' => '/ipanel/#/store/orders/',
            'icon' => 'fa fa-bars',

        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Define Notifiable config to conect to the notification  Module
  |--------------------------------------------------------------------------
  */
    /*
  'notifiable' => [

    [ // Order Entity

      'title' => 'Order',
      'entityName' => 'Modules\\Icommerce\\Entities\\Order',
      'events' => [
        [ //ORDER WAS CREATED
          'title' => 'Order was created',
          'path' => "Modules\\Icommerce\\Events\\OrderWasCreated"
        ]
      ],
      "conditions" => [

      ],
      "settings" => [
        "email" => [
          "recipients" => [
          ]
        ],
      ],
    ]

  ],*/

    /*
    |--------------------------------------------------------------------------
    | Define custom middlewares to apply to the all frontend routes
    |--------------------------------------------------------------------------
    | example: 'logged.in' , 'auth.basic', 'throttle'
    */
    'middlewares' => [],

    /*
  |--------------------------------------------------------------------------
  | Define all the exportable available
  |--------------------------------------------------------------------------
  */
    'exportable' => [
        'orders' => [
            'moduleName' => 'Icommerce',
            'fileName' => 'Orders',
            'exportName' => 'OrdersExport',
        ],
    ],

    /*
 |--------------------------------------------------------------------------
 | Define config to the tenant with central data by model
 |--------------------------------------------------------------------------
 */

    'tenantWithCentralData' => [
        'categories' => false,
        'carts' => false,
        'paymentMethods' => false,
        'shippingMethods' => false,
    ],

    /*
  |--------------------------------------------------------------------------
  | Pages Base
  |--------------------------------------------------------------------------
  */
    'pagesBase' => [

        //Icommerce Index
        'store' => [
            'template' => 'default',
            'is_home' => 0,
            'system_name' => 'store',
            'type' => 'internal',
            'en' => [
                'title' => 'Store',
                'slug' => 'store',
                'body' => '<p>Store</p>',
                'meta_title' => 'Store',
            ],
            'es' => [
                'title' => 'Tienda',
                'slug' => 'tienda',
                'body' => '<p>tienda</p>',
                'meta_title' => 'Tienda',
            ],
        ], //Icommerce Show
        'store-show' => [
            'template' => 'default',
            'is_home' => 0,
            'system_name' => 'store-show',
            'type' => 'internal',
            'en' => [
                'title' => 'Store Show',
                'slug' => 'store-show',
                'body' => '<p>Store show</p>',
                'meta_title' => 'Store show',
            ],
            'es' => [
                'title' => 'Tienda Producto',
                'slug' => 'tienda-producto',
                'body' => '<p>tienda producto</p>',
                'meta_title' => 'Tienda Producto',
            ],

        ],

    ],

    /*
  |--------------------------------------------------------------------------
  | Index Icommerce - Include the partials Organization Header
  |--------------------------------------------------------------------------
  */
    'useTenantHeaderInTheIndex' => true,

    /*
   |--------------------------------------------------------------------------
   |name card
   |--------------------------------------------------------------------------
  */

    /*
   customer, billing-details, shipping-details,
   shipping-methods, payment-methods, order-summary
  */

    'onePageCheckout' => [
        'columns' => [
            'first' => [
                'class' => 'col-12 col-md-6 col-lg-4 colum-1',
                'cards' => [
                    'customer',
                ],
            ],
            'second' => [
                'class' => 'col-12 col-md-6 col-lg-4 colum-2',
                'cards' => [
                    'billing-details', 'shipping-details',
                ],
            ],
            'third' => [
                'class' => 'col-12 col-md-6 col-lg-4 colum-3',
                'cards' => [
                    'shipping-methods', 'payment-methods', 'order-summary',
                ],
            ],
        ],
    ],

    //Order position Info card

    'infoCardCheckout' => [
        'customerData' => [
            'numberPosition' => '1',
        ],
        'billingDetails' => [
            'numberPosition' => '2',
        ],
        'shippingDetails' => [
            'numberPosition' => '3',
        ],
        'shippingMethods' => [
            'numberPosition' => '4',
        ],
        'paymentMethods' => [
            'numberPosition' => '5',
        ],
    ],

    /*Translate keys of each entity. Based on the permission string*/
    'documentation' => [
        'products' => 'icommerce::cms.documentation.products',
        'categories' => 'icommerce::cms.documentation.categories',
        'options' => 'icommerce::cms.documentation.options',
        'payment-methods' => 'icommerce::cms.documentation.payment-methods',
        'shipping-methods' => 'icommerce::cms.documentation.shipping-methods',
        'orders' => 'icommerce::cms.documentation.orders',
        'coupons' => 'icommerce::cms.documentation.coupons',
        'manufacturers' => 'icommerce::cms.documentation.manufacturers',
        'taxclasses' => 'icommerce::cms.documentation.taxclasses',
        'currencies' => 'icommerce::cms.documentation.currencies',
        'quotes' => 'icommerce::cms.documentation.quotes',
    ],
];
