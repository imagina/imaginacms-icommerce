<?php

return [
  'store' => [
    'index' => 'tienda',
    'category' => 'tienda/c/{categorySlug}',
    'product' => 'tienda/p/{productSlug}',
    'wishlist' => 'lista-de-deseos',
    'order' => [
      'index' => 'ordenes',
      'show' => 'ordenes/{orderId}'
    ]
  ],
];