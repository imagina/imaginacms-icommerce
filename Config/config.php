<?php

return [
  'name' => 'Icommerce',
  'frontendModuleName' => 'qcommerce',
  'orderStatuses' => [
    '1' => [
      'id' => 1,
      'title' => 'icommerce::orderstatuses.statuses.processing',
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
      'title' => 'icommerce::orderstatuses.statuses.pending',
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

  'useOldRoutes' => false,

  'defaultProductRating' => 5,

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
  'formatmoney' => [
    'decimals' => 0,
    'dec_point' => '.',
    'housands_sep' => '.'
  ],
  //add: custom product includes (if they are empty icommerce module will be using default includes) (slim)
  'includes' => [
    /*'ProductTransformer'=>[
      'post'=>[
        'path'=>'Modules\Iblog\Transformers\PostTransformer', //this is the transformer path
        'multiple'=>false, //if is one-to-many, multiple must be set to true
      ],
    ]*/
  ],
  //add: product relations like users relations style
  'relations' => [
    'product'=>[
      /*'post' => function () {
        return $this->hasOne(
          \Modules\Iblog\Entities\Post::class, 'product_id');
      },*/
    ]
  ],

  //end custom includes and transformers
  "mediaFillable" => [
    'category' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single',
      'quaternaryimage' => 'single',
      'iconimage' => 'single',
      'bannerindeximage' => 'single',
      'carouselindeximage' => 'multiple',
      'carouseltopindeximages' => 'multiple'
    ],
    'manufacturer' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single',
      'tertiaryimage' => 'single',
      'quaternaryimage' => 'single',
      'carouseltopindeximages' => 'multiple'
    ],
    'paymentmethod' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single'
    ],
    'shippingmethod' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single'
    ],
    'optionvalue' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single'
    ],
    'product' => [
      'mainimage' => 'single',
      'gallery' => 'multiple',
      'secondaryimage' => 'single',
      'quaternaryimage' => 'single',
    ]
  ],

  /**
   *
   *
   * Configs of the Index view
   *
   *
   */

  /* Order By - Index */
  'orderBy' =>[
    'default' => 'recently',
    'options' => [
      'nameaz' => [
        'title' => 'icommerce::common.sort.name_a_z',
        'name' => 'nameaz',
        'order' => [
          'field' => "name",
          'way' => "asc",
        ]
      ],
      'nameza' => [
        'title' => 'icommerce::common.sort.name_z_a',
        'name' => 'nameza',
        'order' => [
          'field' => "name",
          'way' => "desc",
        ]
      ],
      'lowerprice' => [
        'title' => 'icommerce::common.sort.price_low_high',
        'name' => 'lowerprice',
        'order' => [
          'field' => "price",
          'way' => "asc",
        ]
      ],
      'higherprice' => [
        'title' => 'icommerce::common.sort.price_high_low',
        'name' => 'higherprice',
        'order' => [
          'field' => "price",
          'way' => "desc",
        ]
      ],
      'recently' => [
        'title' => 'icommerce::common.sort.recently',
        'name' => 'recently',
        'order' => [
          'field' => "created_at",
          'way' => "desc",
        ]
      ]
    ],
  ],

  /*Layout Products - Index */
  'layoutIndex' => [
    'default' => 'four',
    'options' => [
      'four' => [
        'name' => 'four',
        'class' => 'col-12 col-md-4 col-lg-3',
        'icon' => 'fa fa-th-large',
        'status' => true
      ],
      'three' => [
        'name' => 'three',
        'class' => 'col-12 col-md-4 col-lg-4',
        'icon' => 'fa fa-square-o',
        'status' => true
      ],
      'one' => [
        'name' => 'one',
        'class' => 'col-12',
        'icon' => 'fa fa-align-justify',
        'status' => true
      ],
    ]
  ],

  /*Custom Includes Before Filters*/
  'customIncludesBeforeFilters' => [
    /*
    'manufacturerCard' => [
      'view' => "icommerce.partials.manufacturer-card",
      'show' => ['manufacturer'] //category, manufacturer
    ]
    */
  ],

  /*Filters*/
  'filters'=>[
    'categories' => [
      'title' => 'icommerce::categories.plural',
      /*
       * Mode for render:
       *  allTree
       *  allFamilyOfTheSelectedNode
       *  onlyLeftAndRightOfTheSelectedNode
       */
      'mode' => 'allTree',
      'status' => true,
      'isExpanded' => true,
    ],
    'range-prices' => [
      'title' => 'icommerce::common.range.title',
      'status' => true
    ],
    'manufacturers' => [
      'title' => 'icommerce::manufacturers.plural',
      'status' => true,
      'isExpanded' => false,
    ],
    'product-options' => [
      'title' => 'icommerce::productoptions.plural',
      'status' => true
    ],
    'product-types' => [
      'title' => 'icommerce::common.product-type.title',
      'status' => true,
      'isExpanded' => false,
      'options' => [
        'affordable' => [
          'title' => 'icommerce::common.product-type.affordable',
          'status' => true
        ],
        'searchable' => [
          'title' => 'icommerce::common.product-type.searchable',
          'status' => true
        ],
      ]
    ]
  ],

  /*Widgets Components*/
  'widgets' => [
    "carousel-vertical" => [
      "component" => "icommerce::widgets.carousel-vertical",
      "status" => false,
      "id" => "widgetFeaturedProducts",
      "title" => "Destacados",
      "isExpanded" => true,
      "props" => [
        'itemsBySlide' => 3,
        'params' => ['filter' => ['featured' => true]],
        'responsive' => [0 => ['items' =>  1],640 => ['items' => 1],992 => ['items' => 1]]
      ]
    ]
  ],

  /*Extra Footer Partials*/
  'extraFooter' => [
    'carouselBestSellers' => [
        'status' => false,
        'id' => "extraBestSellers",
        'title' => 'Lo que necesitas aqui',
        'subTitle' => 'Los Más Vendidos',
        'props' => [
          'params' => ['filter' => ['featured' => true]],
          'responsive' => [0 => ['items' =>  1],640 => ['items' => 2],992 => ['items' => 4]]
        ]
    ]
  ],

  /**
   * @note routeName param must be set without locale. Ex: (icommerce orders: 'icommerce.store.order.index')
   */
  "userMenuLinks" => [
      [
          "title" => "icommerce::orders.title.orders",
          "routeName" => "icommerce.store.order.index",
          "icon" => "fa fa-bars",
      ],
      [
          "title" => "icommerce::wishlists.title.wishlists",
          "routeName" => "icommerce.store.wishlists.index",
          "icon" => "fa fa-heart",
      ]
  ]


];
