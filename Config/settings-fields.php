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

  
  'letMeKnowProductIsAvailableForm' => [
    "onlySuperAdmin" => true,
    'name' => 'icommerce::letMeKnowProductIsAvailableForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'icommerce::common.settings.letMeKnowProductIsAvailableForm',
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

  'showRatingInReviewsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::showRatingInReviewsProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.product.showRatingInReviewsProduct'
    ]
  ],
  
  'tenantWithCentralData' => [
    'value' => [],
    'name' => 'icommerce::tenantWithCentralData',
    'groupName' => 'tenantConfiguration',
    'groupTitle' => 'icommerce::common.settings.tenant.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.tenant.tenantWithCentralData',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'icommerce::common.settings.tenant.entities.products', 'value' => 'products'],
        ['label' => 'icommerce::common.settings.tenant.entities.categories', 'value' => 'categories'],
        ['label' => 'icommerce::common.settings.tenant.entities.carts', 'value' => 'carts'],
        ['label' => 'icommerce::common.settings.tenant.entities.paymentMethods', 'value' => 'paymentMethods'],
        ['label' => 'icommerce::common.settings.tenant.entities.shippingMethods', 'value' => 'shippingMethods'],
        ['label' => 'icommerce::common.settings.tenant.entities.orders', 'value' => 'orders'],
      ]
    ]
  ],
  
  'productDiscountRibbonStyle' => [
    'value' => 'flag',
    'name' => 'icommerce::productDiscountRibbonStyle',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Estilo del Descuento',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Bandera', 'value' => 'flag'],
        ['label' => 'Círculo', 'value' => 'circle'],
        ['label' => 'Cuadrado', 'value' => 'square'],
      ]
    ]
  ],
  'productDiscountPosition' => [
    'value' => 'top-right',
    'name' => 'icommerce::productDiscountPosition',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Posición del Descuento',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Superior-Derecha', 'value' => 'top-right'],
        ['label' => 'Supeerior-Izquierda', 'value' => 'top-left'],
      ]
    ]
  ],
  
  'productImageBorder' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::productImageBorder',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productImageBorder'
    ]
  ],
  'productImageBorderColor' => [
    "onlySuperAdmin" => true,
    'value' => "#dddddd",
    'name' => 'icommerce::productImageBorderColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productImageBorderColor'
    ]
  ],
  
  'productImageBorderRadius' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productImageBorderRadius',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productImageBorderRadius'
    ]
  ],
  
  'productExternalPadding' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productExternalPadding',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productExternalPadding'
    ]
  ],
  
  'productExternalBorder' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::productExternalBorder',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productExternalBorder'
    ]
  ],
  
  'productExternalBorderRadius' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productExternalBorderRadius',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productExternalBorderRadius'
    ]
  ],
  
  'productExternalBorderColor' => [
    "onlySuperAdmin" => true,
    'value' => "#dddddd",
    'name' => 'icommerce::productExternalBorderColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productExternalBorderColor'
    ]
  ],
  
  'productExternalShadowOnHover' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productExternalShadowOnHover',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productExternalShadowOnHover'
    ]
  ],
  'productExternalShadowOnHoverColor' => [
    "onlySuperAdmin" => true,
    'value' => "rgba(0, 0, 0, 0.15)",
    'name' => 'icommerce::productExternalShadowOnHoverColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productExternalShadowOnHoverColor'
    ]
  ],
  
  'productAddToCartIcon' => [
    'value' => 'fa-shopping-cart',
    'name' => 'icommerce::productAddToCartIcon',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icono para añadir al carrito',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'fa-shopping-cart', 'value' => 'fa-shopping-cart'],
        ['label' => 'fa-shopping-bag', 'value' => 'fa-shopping-bag'],
        ['label' => 'fa-shopping-basket', 'value' => 'fa-shopping-basket'],
        ['label' => 'fa-cart-plus', 'value' => 'fa-cart-plus'],
      ]
    ]
  ],
  'productWishlistEnable' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productWishlistEnable',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productWishlistEnable'
    ]
  ],
  'productWishlistIcon' => [
    'value' => 'fa-heart-o',
    'name' => 'icommerce::productWishlistIcon',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icono para Wishlist',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'fa-heart-o', 'value' => 'fa-heart-o'],
        ['label' => 'fa-heart', 'value' => 'fa-heart'],
      ]
    ]
  ],
  
  'productWithTextInAddToCart' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productWithTextInAddToCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productWithTextInAddToCart'
    ]
  ],
  'productWithIconInAddToCart' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productWithIconInAddToCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productWithIconInAddToCart'
    ]
  ],
  'productShowButtonsOnMouseHover' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::productShowButtonsOnMouseHover',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productShowButtonsOnMouseHover'
    ]
  ],
  
  'productButtonsLayout' => [
    'value' => 'borders',
    'name' => 'icommerce::productButtonsLayout',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Estilo de Botones',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Bordes a los lados', 'value' => 'borders'],
        ['label' => 'Sin bordes', 'value' => 'without-borders'],
        ['label' => 'Botones Redondos', 'value' => 'rounded'],
        ['label' => 'Botones Semi-cuadrados', 'value' => 'semi-square'],
        ['label' => 'Botones Cuadrados', 'value' => 'square'],
        ['label' => 'Botones Outline Redondos', 'value' => 'outline rounded'],
        ['label' => 'Botones Outline Semi-cuadrados', 'value' => 'outline semi-square'],
        ['label' => 'Botones Outline Cuadrados', 'value' => 'outline square'],
      ]
    ]
  ],
  'productButtonsPosition' => [
    'value' => 'in-content',
    'name' => 'icommerce::productButtonsPosition',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Posición de Botones',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
          ['label' => 'Dentro del Contenido', 'value' => 'in-content'],
          ['label' => 'Luego del Contenido Centrado', 'value' => 'after-content-center'],
          ['label' => 'Sobre la Foto Superior Izquierda', 'value' => 'top-left-in-photo'],
          ['label' => 'Sobre la Foto Superior Centrado', 'value' => 'top-center-in-photo'],
          ['label' => 'Sobre la Foto Superior Derecha', 'value' => 'top-right-in-photo'],
          ['label' => 'Sobre la Foto Inferior Izquierda', 'value' => 'bottom-left-in-photo'],
          ['label' => 'Sobre la Foto Inferior Izquierda en linea', 'value' => 'bottom-left-inline-in-photo'],
          ['label' => 'Sobre la Foto Inferior Centrado', 'value' => 'bottom-center-in-photo'],
          ['label' => 'Sobre la Foto Inferior Derecha', 'value' => 'bottom-right-in-photo'],
          ['label' => 'Sobre la Foto Inferior Derecha en linea', 'value' => 'bottom-right-inline-in-photo'],
          ['label' => 'Sobre la Foto Añadir Inferior Full y Wishlist Superior Centrado', 'value' => 'abf-wtc-in-photo'],
        ]
    ]
  ],
  'productContentAlign' => [
    'value' => 'left',
    'name' => 'icommerce::productContentAlign',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Alineación de Contenido',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'A la Izquierda', 'value' => 'left'],
        ['label' => 'Centrado', 'value' => 'center'],
      ]
    ]
  ],
  'productContentExternalPaddingX' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productContentExternalPaddingX',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentExternalPaddingX'
    ]
  ],
  'productContentExternalPaddingY' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productContentExternalPaddingY',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentExternalPaddingY'
    ]
  ],
  'productAddToCartWithQuantityPaddingX' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productAddToCartWithQuantityPaddingX',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productAddToCartWithQuantityPaddingX'
    ]
  ],
  'productAddToCartWithQuantityPaddingY' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productAddToCartWithQuantityPaddingY',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productAddToCartWithQuantityPaddingY'
    ]
  ],
  'productAddToCartWithQuantityMarginBottom' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'icommerce::productAddToCartWithQuantityMarginBottom',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productAddToCartWithQuantityMarginBottom'
    ]
  ],
  'productContentTitleMaxHeight' => [
    "onlySuperAdmin" => true,
    'value' => 18,
    'name' => 'icommerce::productContentTitleMaxHeight',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentTitleMaxHeight'
    ]
  ],
  
  'productContentTitleFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 14,
    'name' => 'icommerce::productContentTitleFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentTitleFontSize'
    ]
  ],
  
  'productContentTitleNumberOfCharacters' => [
    "onlySuperAdmin" => true,
    'value' => 80,
    'name' => 'icommerce::productContentTitleNumberOfCharacters',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentTitleNumberOfCharacters'
    ]
  ],
  
  'productContentTitleToUppercase' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::productContentTitleToUppercase',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productContentTitleToUppercase'
    ]
  ],
  
  'productContentCategoryFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 8,
    'name' => 'icommerce::productContentCategoryFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentCategoryFontSize'
    ]
  ],
  
  'productContentCategoryEnable' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productContentCategoryEnable',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productContentCategoryEnable'
    ]
  ],
  
  'productContentCategoryToUppercase' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::productContentCategoryToUppercase',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.productContentCategoryToUppercase'
    ]
  ],
  
  'productContentPriceFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 8,
    'name' => 'icommerce::productContentPriceFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'icommerce::common.settings.productContentPriceFontSize'
    ]
  ],
  
  'productContentPriceFontWeight' => [
    'value' => 'normal',
    'name' => 'icommerce::productContentPriceFontWeight',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Precio Negrita (Weight)',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Texto en negrita', 'value' => 'bold'],
        ['label' => 'Texto en negrita (relativo al elemento principal)', 'value' => 'bolder'],
        ['label' => 'Texto de peso normal', 'value' => 'normal'],
        ['label' => 'Texto más ligero (en relación con el elemento principal)', 'value' => 'lighter'],
      ]
    ]
  ],
  

];
