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
    'group' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.product-per-page'
    ],
  ],
  'customIndexTitle' => [
    'name' => 'icommerce::customIndexTitle',
    'value' => '',
    'group' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.customIndexTitle'
    ],
  ],
  'customIndexDescription' => [
    'name' => 'icommerce::customIndexDescription',
    'value' => '',
    'group' => 'icommerce::common.pages.index',
    'type' => 'input',
    'columns' => 'col-12',
    'props' => [
      'label' => 'icommerce::common.settings.customIndexDescription',   
      'type' => 'textarea',
      'rows' => 3  
    ],
  ],

  'carouselIndexCategory' => [
    'value' => 'carousel-category-active',
    'name' => 'icommerce::carouselIndexCategory',
    'group' => 'icommerce::common.pages.index',
    'type' => 'select',
    'props' => [
      'label' => 'Imagenes para el Carousel Top',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Categoria Activa','value' => 'carousel-category-active'],
        ['label' => 'Categoria Padre','value' => 'carousel-category-parent'],
      ]
    ]
  ],
  'showBreadcrumbSidebar' => [
    'value' => false,
    'name' => 'icommerce::showBreadcrumbSidebar',
    'type' => 'checkbox',
    'group' => 'icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar breadcrumb en Sidebar'
    ]
  ],
  'showCategoryChildrenIndexHeader' => [
    'value' => false,
    'name' => 'icommerce::showCategoryChildrenIndexHeader',
    'type' => 'checkbox',
    'group' => 'icommerce::common.pages.index',
    'props' => [
      'label' => 'Mostrar Categorías Hijas en el header del Index'
    ]
  ],
  
  'categoryChildrenIndexHeader' => [
    'value' => 'basic',
    'name' => 'icommerce::filterCategoriesTitle',
    'group' => 'icommerce::common.filters.categories.group',
    'type' => 'select',
    'props' => [
      'label' => 'Titulo a mostrar',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Palabra Categoria','value' => 'basic'],
        ['label' => 'Titulo de la Categoria','value' => 'category-title'],
      ]
    ]
  ],
  
  'filterCategoriesTitle' => [
    'value' => 'basic',
    'name' => 'icommerce::filterCategoriesTitle',
    'group' => 'icommerce::common.filters.categories.group',
    'type' => 'select',
    'props' => [
      'label' => 'Titulo a mostrar',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Palabra Categoria','value' => 'basic'],
        ['label' => 'Titulo de la Categoria','value' => 'category-title'],
      ]
    ]
  ],
  'filterRangePricesStep' => [
    'name' => 'icommerce::filterRangePricesStep',
    'group' => 'icommerce::common.filters.priceRange.group',
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
    'value' => 'product-list-item-layout-1',
    'name' => 'icommerce::productListItemLayout',
    'group' => 'icommerce::common.settings.product.group',
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
        ['label' => 'Product List Layout 1','value' => 'product-list-item-layout-1'],
        ['label' => 'Product List Layout 2','value' => 'product-list-item-layout-2'],
        ['label' => 'Product List Layout 3','value' => 'product-list-item-layout-3']
      ]
    ]
  ],
  'product-add-to-cart-with-quantity' => [
    'name' => 'icommerce::product-add-to-cart-with-quantity',
    'value' => "0",
    'type' => 'checkbox',
    'columns' => 'col-12 col-md-6',
    'group' => 'icommerce::common.settings.product.group',
    'props' => [
      'label' => 'icommerce::common.settings.product-add-to-cart-with-quantity',
      'trueValue' => "1",
      'falseValue' => "0",
    ],
  ],

  'productMinimumQuantityToNotify' => [
    'name' => 'icommerce::productMinimumQuantityToNotify',
    'group' => 'icommerce::common.settings.product.group',
    'value' => 3,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.settings.product.minimumQuantityToNotify'
    ],
  ],
];
