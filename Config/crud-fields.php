<?php

return [
  //Extra field to crud product categories
  'coupons' => [],
  //Extra field to crud product categories
  'manufacturers' => [],
  //Extra field to crud product categories
  'orders' => [],
  //Extra field to crud product categories
  'productCategories' => [
    'iconimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Icono Menú',
        'zone' => 'iconimage',
        'entity' => "Modules\Icommerce\Entities\Category",
        'entityId' => null
      ]
    ],
    'bannerindeximage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Banner Página Índice',
        'zone' => 'bannerindeximage',
        'entity' => "Modules\Icommerce\Entities\Category",
        'entityId' => null
      ]
    ],
    'summaryIndex' => [
      'name' => 'descriptionIndex',
      'value' => '',
      'type' => 'input',
      'fakeFieldName' => 'options',
      'columns' => 'col-12 col-md-6',
      'props' => [
        'label' => 'icommerce::common.crudFields.categoryIndexDescription',
        'type' => 'textarea',
        'rows' => 3,
      ],
    ],
    'carouselIndexImage' => [
      'multiple' => true,
      'value' => (object)[],
      'name' => 'mediasMulti',
      'type' => 'media',
      'props' => [
        'label' => 'Carousel Página Índice',
        'zone' => 'carouselindeximage',
        'entity' => "Modules\Icommerce\Entities\Category",
        'entityId' => null
      ]
    ],
    
    ],
  //Extra field to crud product categories
  'manufacturers' => [],
  //Extra field to crud product categories
  'productDiscounts' => [],
  //Extra field to crud product categories
  'productOptions' => [],
  //Extra field to crud product categories
  'productOptionsValues' => [],
  //Extra field to crud product categories
  'stores' => [],
  //Extra field to crud product categories
  'taxClasses' => [],
  //Extra field to crud product categories
  'taxRates' => []
];
