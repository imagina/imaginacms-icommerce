<?php

return [
  'form-emails' => [
    'name' => 'icommerce::form-emails',
    'value' => null,
    'type' => 'input',
    'group' => 'icommerce::common.pages.index',
    'columns' => 'col-12 col-md-6',
    'props' => [
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
    'props' => [
      'label' => 'icommerce::common.settings.product.layout',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'List Product Layout 1','value' => 'product-list-item-layout-1'],
        ['label' => 'List Product Layout 2','value' => 'product-list-item-layout-2'],
        ['label' => 'List Product Layout 3','value' => 'product-list-item-layout-3']
      ]
    ]
  ],
  'product-price-list-enable' => [
      'name' => 'icommerce::product-price-list-enable',
      'value' => "0",
      'type' => 'checkbox',
      'columns' => 'col-12 col-md-6',
      'group' => 'icommerce::common.filters.priceList.group',
      'props' => [
          'label' => 'icommerce::common.settings.product-price-list-enable',
          'trueValue' => "1",
          'falseValue' => "0",
      ],
  ],
];
