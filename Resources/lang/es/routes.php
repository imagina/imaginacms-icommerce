<?php

return [
  'store' => [
    'index' => 'tienda',
    'category' => 'tienda/c/{categorySlug}',
    'product' => 'tienda/p/{productSlug}',
    'wishlist' => 'tienda/lista-de-deseos',
    'checkout' => 'tienda/checkout',
    'order' => [
      'index' => 'ordenes',
      'show' => 'ordenes/{orderId}'
    ]
  ],
];