<?php

return [
  'store' => [
    'index' => 'store',
    'category' => 'store/c/{categorySlug}',
    'product' => 'store/p/{productSlug}',
    'wishlist' => 'wishlist',
    'order' => [
      'index' => 'orders',
      'show' => 'orders/{orderId}'
    ]
  ],
];