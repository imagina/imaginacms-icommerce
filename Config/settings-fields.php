<?php

return [
  'form-emails' => [
    'name' => 'icommerce::form-emails',
    'value' => null,
    'type' => 'input',
    'props' => [
      'label' => 'icommerce::common.settings.emails'
    ],
  ],
  'product-per-page' => [
    'value' => "12",
    'name' => 'icommerce::product-per-page',
    'type' => 'input',
    'props' => [
      'label' => 'icommerce::settings.product-per-page'
    ],
  ],
  'filter-categories' => [
    'value' => false,
    'name' => 'icommerce::filter-categories',
    'type' => 'checkbox',
    'props' => [
      'label' => 'icommerce::settings.filter-categories.title'
    ]
  ],
  'filter-prices' => [
    'value' => false,
    'name' => 'icommerce::filter-prices',
    'type' => 'checkbox',
    'props' => [
      'label' => 'icommerce::settings.filter-prices.title'
    ]
  ],
  'filter-prices-max' => [
    'value' => "9999999",
    'name' => 'icommerce::filter-prices-max',
    'type' => 'input',
    'props' => [
      'label' => 'icommerce::settings.filter-prices.max'
    ]
  ],
];
