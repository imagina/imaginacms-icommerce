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
    'name' => 'filterRangePricesStep',
    'group' => 'icommerce::common.filters.priceRange.group',
    'value' => 20000,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icommerce::common.filters.priceRange.step'
    ],
  ],
  'product-price-list' => [
      'name' => 'icommerce::product-price-list',
      'value' => "0",
      'type' => 'checkbox',
      'columns' => 'col-12 col-md-6',
      'group' => 'icommerce::common.filters.priceList.group',
      'props' => [
          'label' => 'icommerce::common.settings.product-price-list',
          'trueValue' => "1",
          'falseValue' => "0",
      ],
  ],
];
