<?php

return [
  'usersToNotify' => [
    'name' => 'icommerce::usersToNotify',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.users',
      'select' => ['label' => 'email', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'icommerce::common.settings.usersToNotify',
      'multiple' => true,
      'clearable' => true,
    ],
  ],


  'form-emails' => [
    'name' => 'icommerce::form-emails',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hint' => 'icommerce::common.settingHints.emails',
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'label' => 'icommerce::common.settings.emails'
    ],
  ],


  'product-per-page' => [
    'name' => 'icommerce::product-per-page',
    'value' => 12,
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.product-per-page'
    ],
  ],
  'customIndexTitle' => [
    'name' => 'icommerce::customIndexTitle',
    'value' => '',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.customIndexTitle'
    ],
  ],
  'customIndexDescription' => [
    'name' => 'icommerce::customIndexDescription',
    'value' => '',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12',
    'props' => [
      'label' => 'icommerce::common.settings.customIndexDescription',
      'type' => 'textarea',
      'rows' => 3
    ],
  ],

  'customIndexContactLabel' => [
    'name' => 'icommerce::customIndexContactLabel',
    'value' => 'Contáctenos',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.customIndexContactLabel',
      'type' => 'text',
    ],
  ],

  'carouselIndexCategory' => [
    'value' => 'carousel-category-active',
    'name' => 'icommerce::carouselIndexCategory',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Imagenes para el Carousel Top',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Categoria Activa', 'value' => 'carousel-category-active'],
        ['label' => 'Categoria Padre', 'value' => 'carousel-category-parent'],
      ]
    ]
  ],
  'showBreadcrumbSidebar' => [
    'value' => false,
    'name' => 'icommerce::showBreadcrumbSidebar',
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar breadcrumb en Sidebar'
    ]
  ],
  'showCategoryChildrenIndexHeader' => [
    'value' => false,
    'name' => 'icommerce::showCategoryChildrenIndexHeader',
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar Categorías Hijas en el header del Index'
    ]
  ],

  'categoryChildrenIndexHeader' => [
    'value' => 'basic',
    'name' => 'icommerce::filterCategoriesTitle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'icommerce::common.filters.categories.group',
    'type' => 'select',
    'props' => [
      'label' => 'Titulo a mostrar',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Palabra Categoria', 'value' => 'basic'],
        ['label' => 'Titulo de la Categoria', 'value' => 'category-title'],
      ]
    ]
  ],

  'filterCategoriesTitle' => [
    'value' => 'basic',
    'name' => 'icommerce::filterCategoriesTitle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'icommerce::common.filters.categories.group',
    'type' => 'select',
    'props' => [
      'label' => 'Titulo a mostrar',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Palabra Categoria', 'value' => 'basic'],
        ['label' => 'Titulo de la Categoria', 'value' => 'category-title'],
      ]
    ]
  ],
  'filterRangePricesStep' => [
    'name' => 'icommerce::filterRangePricesStep',
    'groupName' => 'priceRangeFilter',
    'groupTitle' => 'icommerce::common.filters.priceRange.group',
    'value' => 20000,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.filters.priceRange.step'
    ],
  ],

  'daysEnabledForNewProducts' => [
    'name' => 'icommerce::daysEnabledForNewProducts',
    'value' => 15,
    'type' => 'input',
    'group' => 'icommerce::common.settings.product.group',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.daysEnabledForNewProducts',
      'type' => 'number'
    ],
  ],
  'productListItemLayout' => [
    "onlySuperAdmin" => true,
    'value' => 'product-list-item-layout-1',
    'name' => 'icommerce::productListItemLayout',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.product.layout',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Product List Layout 1', 'value' => 'product-list-item-layout-1'],
        ['label' => 'Product List Layout 2', 'value' => 'product-list-item-layout-2'],
        ['label' => 'Product List Layout 3', 'value' => 'product-list-item-layout-3']
      ]
    ]
  ],
  'productAspect' => [
    "onlySuperAdmin" => true,
    'value' => "1-1",
    'name' => 'icommerce::productAspect',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Relación de Aspecto',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => '1 : 1', 'value' => "1-1"],
        ['label' => '4 : 3', 'value' => "4-3"],
      ]
    ]
  ],
  'product-add-to-cart-with-quantity' => [
    "onlySuperAdmin" => true,
    'name' => 'icommerce::product-add-to-cart-with-quantity',
    'value' => "0",
    'type' => 'checkbox',
    'columns' => 'col-12 col-md-6',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'label' => 'icommerce::common.settings.product-add-to-cart-with-quantity',
      'trueValue' => "1",
      'falseValue' => "0",
    ],
  ],

  'productMinimumQuantityToNotify' => [
    'name' => 'icommerce::productMinimumQuantityToNotify',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'value' => 3,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.product.minimumQuantityToNotify'
    ],
  ],
  'filterCategoriesStyle' => [
    'value' => '',
    'name' => 'icommerce::filterCategoriesStyle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'icommerce::common.filters.categories.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Estilo Filtro Categorías',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Default', 'value' => ''],
        ['label' => 'Style TTYS', 'value' => 'filter-categories-style-1'],
        ['label' => 'Style ALNAT', 'value' => 'filter-categories-style-2'],
      ]
    ]
  ],
  'customCheckoutTitle' => [
    'name' => 'icommerce::customCheckoutTitle',
    'value' => '',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'type' => 'input',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.customCheckoutTitle',
      'type' => 'text',
    ],
  ],
  'checkoutLayout' => [
    'value' => 'one-page-checkout',
    'name' => 'icommerce::checkoutLayout',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Layout del Checkout',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'One Page Checkout', 'value' => 'one-page-checkout'],
        ['label' => 'Tabs Checkout', 'value' => 'tabs-checkout'],
      ]
    ],
  ],
  'addToCartButtonAction' => [
    "onlySuperAdmin" => true,
    'value' => 'add-to-cart',
    'name' => 'icommerce::addToCartButtonAction',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.product.addToCartButtonAction',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Add to Cart', 'value' => 'add-to-cart'],
        ['label' => 'go to Show view', 'value' => 'go-to-show-view'],
        ['label' => 'Add to Cart Quote', 'value' => 'add-to-cart-quote'],
      ]
    ]
  ],
  'addToCartQuoteButtonAction' => [
    "onlySuperAdmin" => true,
    'value' => 'add-to-cart-quote',
    'name' => 'icommerce::addToCartQuoteButtonAction',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.product.addToCartQuoteButtonAction',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Add to Cart Quote', 'value' => 'add-to-cart-quote'],
      ]
    ]
  ],
  'showButtonToQuoteInStore' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::showButtonToQuoteInStore',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.product.showButtonToQuoteInStore'
    ]
  ],
  'showButtonThatGeneratesPdfOfTheCart' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::showButtonThatGeneratesPdfOfTheCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.product.showButtonThatGeneratesPdfOfTheCart'
    ]
  ],
  
  'showReviewsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::showReviewsProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.product.showReviewsProduct'
    ]
  ],
  
  'icommerceCartQuoteForm' => [
    "onlySuperAdmin" => true,
    'name' => 'icommerce::icommerceCartQuoteForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'icommerce::common.settings.icommerceCartQuoteForm',
      'multiple' => false,
      'clearable' => true,
    ],
  ],

  'showRatingProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::showRatingProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.product.showRatingProduct'
    ]
  ],
  
  'chatByOrderEnable' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::chatByOrderEnable',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.chatByOrderEnable'
    ]
  ],
];
