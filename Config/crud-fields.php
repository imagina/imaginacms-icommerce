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
      'value' => (object)[],
      'name' => 'mediasMulti',
      'type' => 'media',
      'props' => [
        'multiple' => true,
        'label' => 'Carousel Página Índice',
        'zone' => 'carouselindeximage',
        'entity' => "Modules\Icommerce\Entities\Category",
        'entityId' => null
      ]
    ],

    'carouselTopIndexImages' => [
      'value' => (object)[],
      'name' => 'mediasMulti',
      'type' => 'media',
      'props' => [
        'multiple' => true,
        'label' => 'Carousel Top Página Índice',
        'zone' => 'carouseltopindeximages',
        'entity' => "Modules\Icommerce\Entities\Category",
        'entityId' => null
      ]
    ],

    ],
  //Extra field to crud product categories
  'manufacturers' => [

    'carouselTopIndexImages' => [
      'value' => (object)[],
      'name' => 'mediasMulti',
      'type' => 'media',
      'props' => [
        'multiple' => true,
        'label' => 'Carousel Top Página Índice',
        'zone' => 'carouseltopindeximages',
        'entity' => "Modules\Icommerce\Entities\Manufacturer",
        'entityId' => null
      ]
    ],

  ],
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
  'taxRates' => [],
  //Extra field to crud products
  'products' => [
      //productable extra fields. We recommend you adding a custom relation in config like "productable" in section "relations" > "products", and also a custom include in the section "includes" > "products"
      'productables' => [
          /*'posts' => [
              'loadOptions' => [
                  'apiRoute' => 'apiRoutes.qblog.posts',
                  'select' => [ 'label' => 'title', 'id' => 'id' ],
              ],
              'value' => [], //If the field is not multiple, it must be null. Else, it must be an empty array
              'type' => 'select', //It's recommended to use select or multiselect field types
              'props' => [
                  'label' => 'Entradas',
                  'multiple' => true,
              ],
              'entity' => "Modules\\Iblog\\Entities\\Post", //the productable item must have an entity
          ],*/
      ]
  ] ,

];
