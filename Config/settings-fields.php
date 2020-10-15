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
  'filters' => [
    'name' => 'filters',
    'value' => [],
    'type' => 'select',
    'props' => [
      'label' => "icommerce::settings.filters",
      'multiple' => true,
      'useChips' => true,
      'options' => [
        ['label' => 'Categorias', 'value' => 'filterCategories'],
        ['label' => 'Precios', 'value' => 'filterPrices'],
      ]
    ]
  ]
];
