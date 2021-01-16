<?php

return [
  'store' => [
    'index' => [
      'index' => 'store',
      'category' => 'store/c/{categorySlug}',
      'manufacturer' => 'store/m/{manufacturerSlug}',
      'categoryManufacturer' => 'store/c/{categorySlug}/m/{manufacturerSlug}',
      'wishlist' => 'store/wishlist',
    ],
    
    'show' => [
      'product' => 'store/p/{productSlug}',
    ],
    
    'manufacturer' => [
      'index' => 'store/manufacturers',
      'show' => 'store/manufacturers/{manufacturerSlug}',
    ],
    
    'checkout' => 'store/checkout',
    'order' => [
      'index' => 'store/orders',
      'show' => 'store/orders/{orderId}/{orderKey}'
    ]
  ],
];