<?php

return [
  
  'store' => [
    'index' => [
      'index' => 'tienda',
      'category' => 'tienda/c/{categorySlug}',
      'manufacturer' => 'tienda/m/{manufacturerSlug}',
      'categoryManufacturer' => 'tienda/c/{categorySlug}/m/{manufacturerSlug}',
      'offers' => 'tienda/ofertas',
    ],
    
    'show' => [
      'product' => 'tienda/p/{productSlug}',
    ],
    
    'manufacturer' => [
      'index' => 'tienda/marcas',
      'show' => 'tienda/marcas/{manufacturerSlug}',
    ],
    
    'checkout' => [
      'create' => 'tienda/checkout',
      'update' => 'tienda/checkout/{orderId}',
    ],
    'order' => [
      'index' => 'tienda/ordenes',
      'show' => 'tienda/ordenes/{orderId}/{orderKey}'
    ]
  ],
];