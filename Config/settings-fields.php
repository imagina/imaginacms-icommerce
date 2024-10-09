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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
    'isTranslatable' => true,
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
    'name' => 'icommerce::showBreadcrumbSidebar',
    'type' => 'checkbox',
    'groupName' => 'indexPage',
    'groupTitle' => 'icommerce::common.pages.index',
    "onlySuperAdmin" => true,
    'props' => [
      'label' => 'Mostrar breadcrumb en Sidebar'
    ]
  ],
  'showCategoryChildrenIndexHeader' => [
    'value' => false,
    'name' => 'icommerce::showCategoryChildrenIndexHeader',
    "onlySuperAdmin" => true,
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
    'name' => 'icommerce::filterCategoriesTitle',
    'groupName' => 'categoryFilter',
    'groupTitle' => 'icommerce::common.filters.categories.group',
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
    'name' => 'icommerce::filterRangePricesStep',
    'groupName' => 'priceRangeFilter',
    'groupTitle' => 'icommerce::common.filters.priceRange.group',
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    'name' => 'icommerce::customCheckoutTitle',
    'value' => '',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    "onlySuperAdmin" => true,
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
    'name' => 'icommerce::guestPurchasesByDefault',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.pages.labelDefaultTypeCustomer'
    ]
  ],
  'enableGuestShopping' => [
    "onlySuperAdmin" => true,
    'value' => "1",
    'name' => 'icommerce::enableGuestShopping',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.pages.labelEnableGuestShopping'
    ]
  ],
  'guestShopOnly' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::guestShopOnly',
    'type' => 'checkbox',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.pages.guestShopOnly'
    ]
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
    "onlySuperAdmin" => true,
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
    'name' => 'icommerce::productDiscountPosition',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
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
        ['label' => 'Supeerior-Izquierda', 'value' => 'top-left'],
      ]
    ]
  ],
  'productRibbonBackgroundColor' => [
    "onlySuperAdmin" => true,
    'value' => "#f2c037",
    'name' => 'icommerce::productRibbonBackgroundColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productRibbonBackgroundColor'
    ]
  ],
  'productRibbonTextColor' => [
    "onlySuperAdmin" => true,
    'value' => "#333333",
    'name' => 'icommerce::productRibbonTextColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productRibbonTextColor'
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
    "onlySuperAdmin" => true,
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
  'productContentTitleFontWeight' => [
    'value' => 'normal',
    'name' => 'icommerce::productContentTitleFontWeight',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.productContentTitleFontWeight',
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
  'productContentCategoryFontWeight' => [
    'value' => 'normal',
    'name' => 'icommerce::productContentCategoryFontWeight',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.productContentCategoryFontWeight',
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
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.productContentPriceFontWeight',
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
    'value' => "#ffffff",
    'name' => 'icommerce::productProductBackgroundColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'inputColor',
    'props' => [
      'label' => 'icommerce::common.settings.productProductBackgroundColor'
    ]
  ],
  'productProductBackgroundColor' => [
    "onlySuperAdmin" => true,
    'value' => "transparent",
    'name' => 'icommerce::productProductBackgroundColor',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'input',
    'props' => [
      'label' => 'icommerce::common.settings.productProductBackgroundColor'
    ]
  ],
  'productImageObjectFit' => [
    'value' => 'contain',
    'name' => 'icommerce::productImageObjectFit',
    "onlySuperAdmin" => true,
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.settings.productImageObjectFit',
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
    'name' => 'icommerce::productWithDescription',
    'groupName' => 'product',
    'groupTitle' => 'icommerce::common.settings.product.group',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => '1',
      'falseValue' => '0',
      'label' => 'icommerce::common.settings.productWithDescription'
    ]
  ],
  'layoutProductIcommerce' => [
    'name' => 'icommerce::layoutProductIcommerce',
    'value' => null,
    'type' => 'select',
    'groupName' => 'layouts',
    'groupTitle' => 'icommerce::common.layouts.group_name',
    'loadOptions' => [
      'apiRoute' => '/isite/v1/layouts',
      'select' => ['label' => 'title', 'id' => 'path'],
      'requestParams' => ['filter' => ['entity_name' => 'Product', 'module_name' => 'Icommerce']],
    ],
    'props' => [
      'label' => 'icommerce::common.layouts.label_products_default',
      'entityId' => null,
    ],
  ],
  'layoutCategoryIcommerce' => [
    'name' => 'icommerce::layoutCategoryIcommerce',
    'value' => null,
    'type' => 'select',
    'groupName' => 'layouts',
    'groupTitle' => 'icommerce::common.layouts.group_name',
    'loadOptions' => [
      'apiRoute' => '/isite/v1/layouts',
      'select' => ['label' => 'title', 'id' => 'path'],
      'requestParams' => ['filter' => ['entity_name' => 'Category', 'module_name' => 'Icommerce']],
    ],
    'props' => [
      'label' => 'icommerce::common.layouts.label_categories_default',
      'entityId' => null,
    ],
  ],
  'orderSummaryDescription' => [
    'value' => null,
    'name' => 'icommerce::orderSummaryDescription',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'type' => 'html',
    'props' => [
      'label' => 'icommerce::common.settings.labelOrderSummaryDescription',
    ]
  ],
  'orderSearchResults' => [
    'value' => ['scoreSearch1', 'icommerce__products.created_at', 'scoreSearch2'],
    'name' => 'icommerce::orderSearchResults',
    'groupName' => 'searcher',
    'groupTitle' => 'icommerce::common.search.settings.groupName',
    "onlySuperAdmin" => true,
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.search.settings.labelSearcherOrder',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'icommerce::common.search.settings.options.fullWord', 'value' => 'scoreSearch1'],
        ['label' => 'icommerce::common.search.settings.options.createDate', 'value' => 'icommerce__products.created_at'],
        ['label' => 'icommerce::common.search.settings.options.uniqueWord', 'value' => 'scoreSearch2'],
      ]
    ]
  ],
  'selectSearchFieldsProducts' => [
    'value' => ['name', 'summary', 'description'],
    'name' => 'icommerce::selectSearchFieldsProducts',
    'groupName' => 'searcher',
    'groupTitle' => 'icommerce::common.search.settings.groupName',
    "onlySuperAdmin" => true,
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'icommerce::common.search.settings.labelSearchFields',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'icommerce::common.search.settings.options.name', 'value' => 'name'],
        ['label' => 'icommerce::common.search.settings.options.summary', 'value' => 'summary'],
        ['label' => 'icommerce::common.search.settings.options.description', 'value' => 'description'],
      ]
    ]
  ],
  'checkoutRedirectUrl' => [
    "onlySuperAdmin" => true,
    'value' => null,
    'name' => 'icommerce::checkoutRedirectUrl',
    'type' => 'input',
    'groupName' => 'checkoutPage',
    'groupTitle' => 'icommerce::common.pages.checkout',
    'props' => [
      'type' => "text",
      'label' => 'icommerce::common.settings.checkoutRedirectUrl'
    ]
  ],
  'warehouseFunctionality' => [
    "onlySuperAdmin" => true,
    'value' => "0",
    'name' => 'icommerce::warehouseFunctionality',
    'groupName' => 'warehouse',
    'groupTitle' => 'icommerce::common.settings.warehouse.groupName',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'icommerce::common.settings.warehouse.warehouseFunctionality'
    ]
  ],
  'productGalleryLayout' => [
    "onlySuperAdmin" => true,
    'value' => 'gallery-layout-4',
    'name' => 'icommerce::productGalleryLayout',
    'groupName' => 'page_product',
    'groupTitle' => 'icommerce::common.layouts.page_product',
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.productShowGalleryLayout',
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
    'name' => 'icommerce::productResponsive',
    'groupName' => 'page_product',
    'groupTitle' => 'icommerce::common.layouts.page_product',
    "type" => "json",
    'columns' => 'col-12 col-md-6',
    'props' => [
      "label" => "icommerce::common.settings.productResponsive",
    ]
  ],
  'availableProvincesMap' => [
    'name' => 'icommerce::availableProvincesMap',
    'value' => [],
    'type' => 'select',
    'groupName' => 'warehouse',
    'groupTitle' => 'icommerce::common.settings.warehouse.groupName',
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
    'name' => 'icommerce::availableCitiesMap',
    'value' => [],
    'type' => 'select',
    'groupName' => 'warehouse',
    'groupTitle' => 'icommerce::common.settings.warehouse.groupName',
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
  'daysBeforeDue' => [
    'name' => 'icommerce::daysBeforeDue',
    'value' => 0,
    'type' => 'input',
    'groupName' => 'subscription',
    'groupTitle' => 'icommerce::common.settings.subscription.groupName',
    "onlySuperAdmin" => true,
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.subscription.daysBeforeDue',
      'type' => 'number'
    ],
    'help' => [
      "description" => "icommerce::common.settings.subscription.daysBeforeDueHelp"
    ],
  ],
  'daysForSuspension' => [
    'name' => 'icommerce::daysForSuspension',
    'value' => 5,
    'type' => 'input',
    'groupName' => 'subscription',
    'groupTitle' => 'icommerce::common.settings.subscription.groupName',
    "onlySuperAdmin" => true,
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.subscription.daysForSuspension',
      'type' => 'number'
    ],
    'help' => [
      "description" => "icommerce::common.settings.subscription.daysForSuspensionHelp"
    ],
  ],
];
