<?php

return [
  'store' => [
    'index' => 'store',
    'category' => 'store/c/{categorySlug}',
    'product' => 'store/p/{productSlug}',
    'wishlist' => 'store/wishlist',
    'checkout' => 'store/checkout',
    'order' => [
      'index' => 'orders',
      'show' => 'orders/{orderId}'
    ]
  ],
];