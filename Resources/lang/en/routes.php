<?php

return [
  'store' => [
    'index' => 'store',
    'category' => 'store/c/{categorySlug}',
    'product' => 'store/p/{productSlug}',
    'manufacturer' => 'store/m/{manufacturerSlug}',
    'categoryManufacturer' => 'store/c/{categorySlug}/m/{manufacturerSlug}',
    'wishlist' => 'store/wishlist',
    'checkout' => 'store/checkout',
    'order' => [
      'index' => 'orders',
      'show' => 'orders/{orderId}'
    ]
  ],
];