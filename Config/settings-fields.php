<?php

return [
  'usersToNotify' => [
    'name' => 'Icommerce::usersToNotify',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.users',
      'select' => ['label' => 'email', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'Icommerce::common.settings.usersToNotify',
      'multiple' => true,
      'clearable' => true,
    ],
  ],
  'form-emails' => [
    'name' => 'Icommerce::form-emails',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hint' => 'Icommerce::common.settingHints.emails',
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'label' => 'Icommerce::common.settings.emails'
    ],
  ],
  'product-per-page' => [
    'name' => 'Icommerce::product-per-page',
    'value' => 12,
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.product-per-page'
    ],
  ],
  'customIndexTitle' => [
    'name' => 'Icommerce::customIndexTitle',
    'value' => '',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.customIndexTitle'
    ],
  ],
  'customIndexDescription' => [
    'name' => 'Icommerce::customIndexDescription',
    'value' => '',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'type' => 'input',
    'columns' => 'col-12',
    'props' => [
      'label' => 'Icommerce::common.settings.customIndexDescription',
      'type' => 'textarea',
      'rows' => 3
    ],
  ],
  'customIndexContactLabel' => [
    'name' => 'Icommerce::customIndexContactLabel',
    'value' => 'Contáctenos',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'isTranslatable' => true,
    'type' => 'input',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.customIndexContactLabel',
      'type' => 'text',
    ],
  ],
  'carouselIndexCategory' => [
    'value' => 'carousel-category-active',
    'name' => 'Icommerce::carouselIndexCategory',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
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
    'name' => 'Icommerce::showBreadcrumbSidebar',
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'props' => [
      'label' => 'Mostrar breadcrumb en Sidebar'
    ]
  ],
  'showCategoryChildrenIndexHeader' => [
    'value' => false,
    'name' => 'Icommerce::showCategoryChildrenIndexHeader',
    "onlySuperAdmin" => true,
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar Categorías Hijas en el header del Index'
    ]
  ],
  'showTitleInCarouselCategory' => [
    'value' => false,
    'name' => 'Icommerce::showTitleInCarouselCategory',
    "onlySuperAdmin" => true,
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'Icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar título de las categoria en el carousel'
    ]
  ],
  'categoryChildrenIndexHeader' => [
    'value' => 'basic',
    'name' => 'Icommerce::filterCategoriesTitle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'Icommerce::common.filters.categories.group',
    "onlySuperAdmin" => true,
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
    'name' => 'Icommerce::filterCategoriesTitle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'Icommerce::common.filters.categories.group',
    "onlySuperAdmin" => true,
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
    'name' => 'Icommerce::filterRangePricesStep',
    'groupName' => 'priceRangeFilter',
    'groupTitle' => 'Icommerce::common.filters.priceRange.group',
    "onlySuperAdmin" => true,
    'value' => 20000,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.filters.priceRange.step'
    ],
  ],
  'daysEnabledForNewProducts' => [
    'name' => 'Icommerce::daysEnabledForNewProducts',
    'value' => 15,
    'type' => 'input',
    'group' => 'Icommerce::common.settings.product.group',
    "onlySuperAdmin" => true,
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.daysEnabledForNewProducts',
      'type' => 'number'
    ],
  ],
  'productListItemLayout' => [
    "onlySuperAdmin" => true,
    'value' => 'product-list-item-layout-1',
    'name' => 'Icommerce::productListItemLayout',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.product.layout',
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
    'name' => 'Icommerce::productAspect',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Relación de Aspecto'
    ]
  ],
  'product-add-to-cart-with-quantity' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::product-add-to-cart-with-quantity',
    'value' => "0",
    'type' => 'checkbox',
    'columns' => 'col-12 col-md-6',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'label' => 'Icommerce::common.settings.product-add-to-cart-with-quantity',
      'trueValue' => "1",
      'falseValue' => "0",
    ],
  ],
  'productMinimumQuantityToNotify' => [
    'name' => 'Icommerce::productMinimumQuantityToNotify',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    "onlySuperAdmin" => true,
    'value' => 3,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.product.minimumQuantityToNotify'
    ],
  ],
  'filterCategoriesStyle' => [
    'value' => '',
    'name' => 'Icommerce::filterCategoriesStyle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'Icommerce::common.filters.categories.group',
    "onlySuperAdmin" => true,
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
    'name' => 'Icommerce::customCheckoutTitle',
    'value' => '',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    "onlySuperAdmin" => true,
    'type' => 'input',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.customCheckoutTitle',
      'type' => 'text',
    ],
  ],
  'checkoutLayout' => [
    'value' => 'one-page-checkout',
    'name' => 'Icommerce::checkoutLayout',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    "onlySuperAdmin" => true,
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
        ['label' => 'Two Columns Checkout', 'value' => 'two-columns-checkout'],
      ]
    ],
  ],
  'guestPurchasesByDefault' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::guestPurchasesByDefault',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.pages.labelDefaultTypeCustomer'
    ]
  ],
  'enableGuestShopping' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::enableGuestShopping',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.pages.labelEnableGuestShopping'
    ]
  ],
  'guestShopOnly' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::guestShopOnly',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.pages.guestShopOnly'
    ]
  ],
  'addToCartButtonAction' => [
    "onlySuperAdmin" => true,
    'value' => 'add-to-cart',
    'name' => 'Icommerce::addToCartButtonAction',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.product.addToCartButtonAction',
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
    'name' => 'Icommerce::addToCartQuoteButtonAction',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.product.addToCartQuoteButtonAction',
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
    'name' => 'Icommerce::showButtonToQuoteInStore',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.showButtonToQuoteInStore'
    ]
  ],
  'viewButtonsWhitOptionsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::viewButtonsWhitOptionsProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.viewButtonsWhitOptionsProduct'
    ]
  ],
  'showButtonThatGeneratesPdfOfTheCart' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::showButtonThatGeneratesPdfOfTheCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.showButtonThatGeneratesPdfOfTheCart'
    ]
  ],
  'showReviewsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::showReviewsProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.showReviewsProduct'
    ]
  ],
  'icommerceCartQuoteForm' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::icommerceCartQuoteForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'Icommerce::common.settings.icommerceCartQuoteForm',
      'multiple' => false,
      'clearable' => true,
    ],
  ],
  'letMeKnowProductIsAvailableForm' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::letMeKnowProductIsAvailableForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'Icommerce::common.settings.letMeKnowProductIsAvailableForm',
      'multiple' => false,
      'clearable' => true,
    ],
  ],
  'showRatingProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::showRatingProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.showRatingProduct'
    ]
  ],
  'chatByOrderEnable' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::chatByOrderEnable',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.chatByOrderEnable'
    ]
  ],
  'showRatingInReviewsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::showRatingInReviewsProduct',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.product.showRatingInReviewsProduct'
    ]
  ],
  'tenantWithCentralData' => [
    'value' => [],
    'name' => 'Icommerce::tenantWithCentralData',
    "onlySuperAdmin" => true,
    'groupName' => 'tenantConfiguration',
    'groupTitle' => 'Icommerce::common.settings.tenant.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.tenant.tenantWithCentralData',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Icommerce::common.settings.tenant.entities.products', 'value' => 'products'],
        ['label' => 'Icommerce::common.settings.tenant.entities.categories', 'value' => 'categories'],
        ['label' => 'Icommerce::common.settings.tenant.entities.carts', 'value' => 'carts'],
        ['label' => 'Icommerce::common.settings.tenant.entities.paymentMethods', 'value' => 'paymentMethods'],
        ['label' => 'Icommerce::common.settings.tenant.entities.shippingMethods', 'value' => 'shippingMethods'],
        ['label' => 'Icommerce::common.settings.tenant.entities.orders', 'value' => 'orders'],
      ]
    ]
  ],
  'productDiscountRibbonStyle' => [
    'value' => 'flag',
    'name' => 'Icommerce::productDiscountRibbonStyle',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    "onlySuperAdmin" => true,
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
    'name' => 'Icommerce::productDiscountPosition',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    "onlySuperAdmin" => true,
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
        ['label' => 'Superior-Izquierda', 'value' => 'top-left'],
      ]
    ]
  ],
  'productRibbonBackgroundColor' => [
    "onlySuperAdmin" => true,
    'value' => "#f2c037",
    'name' => 'Icommerce::productRibbonBackgroundColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productRibbonBackgroundColor'
    ]
  ],
  'productRibbonTextColor' => [
    "onlySuperAdmin" => true,
    'value' => "#333333",
    'name' => 'Icommerce::productRibbonTextColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productRibbonTextColor'
    ]
  ],
  'productRibbonTextSize' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::productRibbonTextSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productRibbonTextSize'
    ]
  ],
  'productRibbonLabelSize' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::productRibbonLabelSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productRibbonLabelSize'
    ]
  ],
  'productImageBorder' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productImageBorder',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productImageBorder'
    ]
  ],
  'productSecondaryImageHover' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productSecondaryImageHover',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productSecondaryImageHover'
    ]
  ],
  'transitionImage' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::transitionImage',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'value' => 'opacity 0.5s ease-in-out',
    'props' => [
      'label' => 'Icommerce::common.settings.transitionImage',
    ]
  ],
  'productImageBorderColor' => [
    "onlySuperAdmin" => true,
    'value' => "#dddddd",
    'name' => 'Icommerce::productImageBorderColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productImageBorderColor'
    ]
  ],
  'productImageBorderRadius' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productImageBorderRadius',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productImageBorderRadius'
    ]
  ],
  'productExternalPadding' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productExternalPadding',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productExternalPadding'
    ]
  ],
  'productExternalBorder' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productExternalBorder',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productExternalBorder'
    ]
  ],
  'productExternalBorderRadius' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productExternalBorderRadius',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productExternalBorderRadius'
    ]
  ],
  'productExternalBorderColor' => [
    "onlySuperAdmin" => true,
    'value' => "#dddddd",
    'name' => 'Icommerce::productExternalBorderColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productExternalBorderColor'
    ]
  ],
  'productExternalShadowOnHover' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productExternalShadowOnHover',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productExternalShadowOnHover'
    ]
  ],
  'productExternalShadowOnHoverColor' => [
    "onlySuperAdmin" => true,
    'value' => "rgba(0, 0, 0, 0.15)",
    'name' => 'Icommerce::productExternalShadowOnHoverColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productExternalShadowOnHoverColor'
    ]
  ],
  'productAddToCartIcon' => [
    'value' => 'fa-shopping-cart',
    'name' => 'Icommerce::productAddToCartIcon',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
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
    'name' => 'Icommerce::productWishlistEnable',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productWishlistEnable'
    ]
  ],
  'productWishlistIcon' => [
    'value' => 'fa-heart-o',
    'name' => 'Icommerce::productWishlistIcon',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
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
    'name' => 'Icommerce::productWithTextInAddToCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productWithTextInAddToCart'
    ]
  ],
  'productWithIconInAddToCart' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productWithIconInAddToCart',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productWithIconInAddToCart'
    ]
  ],
  'productShowButtonsOnMouseHover' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productShowButtonsOnMouseHover',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productShowButtonsOnMouseHover'
    ]
  ],
  'productButtonsLayout' => [
    'value' => 'borders',
    'name' => 'Icommerce::productButtonsLayout',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
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
    'name' => 'Icommerce::productButtonsPosition',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
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
    'name' => 'Icommerce::productContentAlign',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
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
    'name' => 'Icommerce::productContentExternalPaddingX',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentExternalPaddingX'
    ]
  ],
  'productContentExternalPaddingY' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productContentExternalPaddingY',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentExternalPaddingY'
    ]
  ],
  'productAddToCartWithQuantityPaddingX' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productAddToCartWithQuantityPaddingX',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productAddToCartWithQuantityPaddingX'
    ]
  ],
  'productAddToCartWithQuantityPaddingY' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productAddToCartWithQuantityPaddingY',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productAddToCartWithQuantityPaddingY'
    ]
  ],
  'productAddToCartWithQuantityMarginBottom' => [
    "onlySuperAdmin" => true,
    'value' => 0,
    'name' => 'Icommerce::productAddToCartWithQuantityMarginBottom',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productAddToCartWithQuantityMarginBottom'
    ]
  ],
  'productContentTitleMaxHeight' => [
    "onlySuperAdmin" => true,
    'value' => 18,
    'name' => 'Icommerce::productContentTitleMaxHeight',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentTitleMaxHeight'
    ]
  ],
  'productContentTitleFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 14,
    'name' => 'Icommerce::productContentTitleFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentTitleFontSize'
    ]
  ],
  'productContentTitleNumberOfCharacters' => [
    "onlySuperAdmin" => true,
    'value' => 80,
    'name' => 'Icommerce::productContentTitleNumberOfCharacters',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentTitleNumberOfCharacters'
    ]
  ],
  'productContentTitleToUppercase' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productContentTitleToUppercase',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productContentTitleToUppercase'
    ]
  ],
  'productContentTitleFontWeight' => [
    'value' => 'normal',
    'name' => 'Icommerce::productContentTitleFontWeight',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productContentTitleFontWeight',
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
  'productContentCategoryFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 8,
    'name' => 'Icommerce::productContentCategoryFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentCategoryFontSize'
    ]
  ],
  'productContentCategoryEnable' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productContentCategoryEnable',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productContentCategoryEnable'
    ]
  ],
  'productContentCategoryToUppercase' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productContentCategoryToUppercase',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productContentCategoryToUppercase'
    ]
  ],
  'productContentCategoryFontWeight' => [
    'value' => 'normal',
    'name' => 'Icommerce::productContentCategoryFontWeight',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productContentCategoryFontWeight',
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
  'productContentPriceFontSize' => [
    "onlySuperAdmin" => true,
    'value' => 8,
    'name' => 'Icommerce::productContentPriceFontSize',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productContentPriceFontSize'
    ]
  ],
  'productContentPriceFontWeight' => [
    'value' => 'normal',
    'name' => 'Icommerce::productContentPriceFontWeight',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productContentPriceFontWeight',
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
  'productProductBackgroundColor' => [
    "onlySuperAdmin" => true,
    'value' => "transparent",
    'name' => 'Icommerce::productProductBackgroundColor',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'input',
    'props' => [
      'label' => 'Icommerce::common.settings.productProductBackgroundColor'
    ]
  ],
  'productImageObjectFit' => [
    'value' => 'contain',
    'name' => 'Icommerce::productImageObjectFit',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productImageObjectFit',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ["label" => "Contain", "value" => "contain"],
        ["label" => "Cover", "value" => "cover"],
        ["label" => "Fill", "value" => "fill"],
        ["label" => "Inicial", "value" => "inicial"],
        ["label" => "Revert", "value" => "revert"],
        ["label" => "Scale-down", "value" => "scale Down"],
        ["label" => "Unset", "value" => "unset"],
        ["label" => "none", "value" => "none"]
      ]
    ]
  ],
  'productWithDescription' => [
    "onlySuperAdmin" => true,
    'value' => '0',
    'name' => 'Icommerce::productWithDescription',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => '1',
      'falseValue' => '0',
      'label' => 'Icommerce::common.settings.productWithDescription'
    ]
  ],
  'layoutProductIcommerce' => [
    'name' => 'Icommerce::layoutProductIcommerce',
    'value' => null,
    'type' => 'select',
    'groupName' => 'layouts',
    'groupTitle' => 'Icommerce::common.layouts.group_name',
    'loadOptions' => [
      'apiRoute' => '/isite/v1/layouts',
      'select' => ['label' => 'title', 'id' => 'path'],
      'requestParams' => ['filter' => ['entity_name' => 'Product', 'module_name' => 'Icommerce']],
    ],
    'props' => [
      'label' => 'Icommerce::common.layouts.label_products_default',
      'entityId' => null,
    ],
  ],
  'layoutCategoryIcommerce' => [
    'name' => 'Icommerce::layoutCategoryIcommerce',
    'value' => null,
    'type' => 'select',
    'groupName' => 'layouts',
    'groupTitle' => 'Icommerce::common.layouts.group_name',
    'loadOptions' => [
      'apiRoute' => '/isite/v1/layouts',
      'select' => ['label' => 'title', 'id' => 'path'],
      'requestParams' => ['filter' => ['entity_name' => 'Category', 'module_name' => 'Icommerce']],
    ],
    'props' => [
      'label' => 'Icommerce::common.layouts.label_categories_default',
      'entityId' => null,
    ],
  ],
  'orderSummaryDescription' => [
    'value' => null,
    'name' => 'Icommerce::orderSummaryDescription',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    'type' => 'html',
    'props' => [
      'label' => 'Icommerce::common.settings.labelOrderSummaryDescription',
    ]
  ],
  'orderSearchResults' => [
    'value' => ['scoreSearch1', 'icommerce__products.created_at', 'scoreSearch2'],
    'name' => 'Icommerce::orderSearchResults',
    'groupName' => 'searcher',
    'groupTitle' => 'Icommerce::common.search.settings.groupName',
    "onlySuperAdmin" => true,
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.search.settings.labelSearcherOrder',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Icommerce::common.search.settings.options.name_position', 'value' => 'name_position'],
        ['label' => 'Icommerce::common.search.settings.options.fullWord', 'value' => 'scoreSearch1'],
        ['label' => 'Icommerce::common.search.settings.options.createDate', 'value' => 'icommerce__products.created_at'],
        ['label' => 'Icommerce::common.search.settings.options.uniqueWord', 'value' => 'scoreSearch2'],
      ]
    ]
  ],
  'selectSearchFieldsProducts' => [
    'value' => ['name', 'summary', 'description'],
    'name' => 'Icommerce::selectSearchFieldsProducts',
    'groupName' => 'searcher',
    'groupTitle' => 'Icommerce::common.search.settings.groupName',
    "onlySuperAdmin" => true,
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.search.settings.labelSearchFields',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Icommerce::common.search.settings.options.name', 'value' => 'name'],
        ['label' => 'Icommerce::common.search.settings.options.summary', 'value' => 'summary'],
        ['label' => 'Icommerce::common.search.settings.options.description', 'value' => 'description'],
      ]
    ]
  ],
  'checkoutRedirectUrl' => [
    "onlySuperAdmin" => true,
    'value' => null,
    'name' => 'Icommerce::checkoutRedirectUrl',
    'type' => 'input',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'Icommerce::common.pages.checkout',
    'props' => [
      'type' => "text",
      'label' => 'Icommerce::common.settings.checkoutRedirectUrl'
    ]
  ],
  'warehouseFunctionality' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::warehouseFunctionality',
    'groupName' => 'warehouse',
    'groupTitle' => 'Icommerce::common.settings.warehouse.groupName',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.warehouse.warehouseFunctionality'
    ]
  ],
  'productShowButtonBuy' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productShowButtonBuy',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'columns' => 'col-12',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productShowButtonBuy'
    ]
  ],
  'productSelectSettingButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => 'isite::whatsapp1',
    'name' => 'Icommerce::productSelectSettingButtonBuyWhatsApp',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productSelectSettingButtonBuyWhatsApp',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'whatsapp 1', 'value' => 'isite::whatsapp1'],
        ['label' => 'whatsapp 2', 'value' => 'isite::whatsapp2'],
        ['label' => 'whatsapp 3', 'value' => 'isite::whatsapp3'],
      ]
    ]
  ],
  'productShowButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productShowButtonBuyWhatsApp',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productShowButtonBuyWhatsApp'
    ]
  ],
  'showCommentsProduct' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::showCommentsProduct',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.showCommentsProduct'
    ]
  ],
  'showExtraPriceInOptions' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::showExtraPriceInOptions',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.showExtraPriceInOptions'
    ]
  ],
  'showQuantityInOptions' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::showQuantityInOptions',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.showQuantityInOptions'
    ]
  ],
  'productShowButtonBuyWhatsAppTextMessage' => [
    "onlySuperAdmin" => true,
    'value' => "Estoy interesad@ en",
    'name' => 'Icommerce::productShowButtonBuyWhatsAppTextMessage',
    'type' => 'input',
    'groupName' => 'page_product',
    'isTranslatable' => true,
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'props' => [
      'label' => 'Icommerce::common.settings.productShowButtonBuyWhatsAppTextMessage'
    ]
  ],
  'productGalleryLayout' => [
    "onlySuperAdmin" => true,
    'value' => 'gallery-layout-4',
    'name' => 'Icommerce::productGalleryLayout',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productShowGalleryLayout',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Gallery 1', 'value' => 'gallery-layout-1'],
        ['label' => 'Gallery 2', 'value' => 'gallery-layout-2'],
        ['label' => 'Gallery 3', 'value' => 'gallery-layout-3'],
        ['label' => 'Gallery 4', 'value' => 'gallery-layout-4'],
        ['label' => 'Gallery 5', 'value' => 'gallery-layout-5'],
        ['label' => 'Gallery 6', 'value' => 'gallery-layout-6'],
        ['label' => 'Gallery 7', 'value' => 'gallery-layout-7']
      ]
    ]
  ],
  'productResponsive' => [
    "onlySuperAdmin" => true,
    "value" => [0 => ["items" => 2], 640 => ["items" => 3], 992 => ["items" => 4]],
    'name' => 'Icommerce::productResponsive',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    "type" => "json",
    'columns' => 'col-12 col-md-6',
    'props' => [
      "label" => "Icommerce::common.settings.productResponsive",
    ]
  ],
  'availableProvincesMap' => [
    'name' => 'Icommerce::availableProvincesMap',
    'value' => [],
    'type' => 'select',
    'groupName' => 'warehouse',
    'groupTitle' => 'Icommerce::common.settings.warehouse.groupName',
    'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
    'props' => [
      'clearable' => true,
      'multiple' => true,
      'label' => 'ilocations::common.settings.availableProvinces',
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qlocations.provinces', //apiRoute to request
      'select' => ['label' => 'name', 'id' => 'iso2'], //Define fields to config select
      'filterByQuery' => true,
      'requestParams' => [
        "filter" => [
          "indexAll" => true
        ]
      ]
    ]
  ],
  'availableCitiesMap' => [
    'name' => 'Icommerce::availableCitiesMap',
    'value' => [],
    'type' => 'select',
    'groupName' => 'warehouse',
    'groupTitle' => 'Icommerce::common.settings.warehouse.groupName',
    'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
    'props' => [
      'clearable' => true,
      'multiple' => true,
      'label' => 'ilocations::common.settings.availableCities',
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qlocations.cities', //apiRoute to request
      'select' => ['label' => 'name', 'id' => 'id'], //Define fields to config select
      'filterByQuery' => true,
      'requestParams' => [
        "filter" => [
          "indexAll" => true
        ]
      ]
    ]
  ],
  'enableProductDetails' => [
    'value' => false,
    'name' => 'Icommerce::enableProductDetails',
    'type' => 'checkbox',
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    "onlySuperAdmin" => true,
    'props' => [
      'label' => 'Icommerce::common.settings.enableProductDetails'
    ]
  ],
  'maximumNumberOfCharactersInputDetails' => [
    'name' => 'Icommerce::maximumNumberOfCharactersInputDetails',
    'value' => 100,
    'groupName' => 'page_product',
    'groupTitle' => 'Icommerce::common.layouts.page_product',
    "onlySuperAdmin" => true,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'Icommerce::common.settings.maximumNumberOfCharactersInputDetails'
    ],
  ],
  'productWithTextButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'Icommerce::productWithTextButtonBuyWhatsApp',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productWithTextButtonBuyWhatsApp'
    ]
  ],
  'productColorButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => "#25D366",
    'name' => 'Icommerce::productColorButtonBuyWhatsApp',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'Icommerce::common.settings.productColorButtonBuyWhatsApp'
    ]
  ],
  'productFontSizeButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => 13,
    'name' => 'Icommerce::productFontSizeButtonBuyWhatsApp',
    'type' => 'input',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'type' => "number",
      'label' => 'Icommerce::common.settings.productFontSizeButtonBuyWhatsApp'
    ]
  ],
  'productPositionButtonBuyWhatsApp' => [
    'value' => "1",
    'name' => 'Icommerce::productPositionButtonBuyWhatsApp',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Icommerce::common.settings.productPositionButtonBuyWhatsApp',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ["label" => "Fuera de los Botones", "value" => "1"],
        ["label" => "Junto a los Botones", "value" => "0"],
      ]
    ]
  ],
  'productWithStyleButtonBuyWhatsApp' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'Icommerce::productWithStyleButtonBuyWhatsApp',
    'type' => 'checkbox',
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'Icommerce::common.settings.productWithStyleButtonBuyWhatsApp'
    ]
  ],
  'productAlignButtonBuyWhatsApp' => [
    'value' => 'text-center',
    'name' => 'Icommerce::productAlignButtonBuyWhatsApp',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Alineación de Botón WhatsApp',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Izquierda', 'value' => 'text-left'],
        ['label' => 'Derecha', 'value' => 'text-right'],
        ['label' => 'Centrado', 'value' => 'text-center'],
      ]
    ]
  ],
  'productClassButtonBuyWhatsApp' => [
    'value' => '',
    'name' => 'Icommerce::productClassButtonBuyWhatsApp',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'Icommerce::common.settings.product.group',
    'type' => 'input',
    'columns' => 'col-6',
    'props' => [
      'label' => 'Clases Adicionales de Botón WhatsApp',
    ]
  ],
  'globalWarehouse' => [
    "onlySuperAdmin" => true,
    'name' => 'Icommerce::globalWarehouse',
    'value' => [],
    'type' => 'select',
    'groupName' => 'warehouse',
    'groupTitle' => 'Icommerce::common.settings.warehouse.groupName',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qcommerce.warehouses',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'Icommerce::common.settings.warehouse.globalWarehouse.title',
      'multiple' => false,
      'clearable' => true,
    ],
    'help' => [
      "description" => "Icommerce::common.settings.warehouse.globalWarehouse.help"
    ],
  ],
];
