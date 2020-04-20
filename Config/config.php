<?php

return [
    'name' => 'Icommerce',
    'frontendModuleName' => 'qcommerce',
    'orderStatuses' => [
        '1' => [
            'id' => 1,
            'title' => 'icommerce::orderstatuses.statuses.processing',
        ],
        '2' => [
            'id' => 2,
            'title' => 'icommerce::orderstatuses.statuses.shipped',
        ],
        '3' => [
            'id' => 3,
            'title' => 'icommerce::orderstatuses.statuses.canceled',
        ],
        '4' => [
            'id' => 4,
            'title' => 'icommerce::orderstatuses.statuses.completed',
        ],
        '5' => [
            'id' => 5,
            'title' => 'icommerce::orderstatuses.statuses.denied',
        ],
        '6' => [
            'id' => 6,
            'title' => 'icommerce::orderstatuses.statuses.canceledreversal',
        ],
        '7' => [
            'id' => 7,
            'title' => 'icommerce::orderstatuses.statuses.failed',
        ],
        '8' => [
            'id' => 8,
            'title' => 'icommerce::orderstatuses.statuses.refunded',
        ],
        '9' => [
            'id' => 9,
            'title' => 'icommerce::orderstatuses.statuses.reserved',
        ],
        '10' => [
            'id' => 10,
            'title' => 'icommerce::orderstatuses.statuses.chargeback',
        ],
        '11' => [
            'id' => 11,
            'title' => 'icommerce::orderstatuses.statuses.pending',
        ],
        '12' => [
            'id' => 12,
            'title' => 'icommerce::orderstatuses.statuses.voided',
        ],
        '13' => [
            'id' => 13,
            'title' => 'icommerce::orderstatuses.statuses.processed',
        ],
        '14' => [
            'id' => 14,
            'title' => 'icommerce::orderstatuses.statuses.expired',
        ],
    ],
  'itemTypes' => [
    '1' => [
      'id' => 1,
      'title' => 'icommerce::itemtypes.types.product',
    ],
    '2' => [
      'id' => 2,
      'title' => 'icommerce::itemtypes.types.service',
    ],
    '3' => [
      'id' => 3,
      'title' => 'icommerce::itemtypes.types.other',
    ],
  ],
  'formatmoney' => [
      'decimals' => 2,
      'dec_point' => '.',
      'housands_sep' => ','
  ],
];
