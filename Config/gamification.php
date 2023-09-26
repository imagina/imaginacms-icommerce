<?php

$transPrefix = 'icommerce::igamification';

return [
    //Categories
    'categories' => [],
    //Activities
    'activities' => [
        [
            'systemName' => 'admin_home_actions_createProduct',
            'title' => "$transPrefix.activities.createProduct",
            'description' => "$transPrefix.activities.createProductDescription",
            'type' => 1,
      'url' => "iadmin/#/ecommerce/products?create=call",
      'permission' => 'icommerce.products.manage',
            'categoryId' => 'admin_home_actions',
            'icon' => 'fa-light fa-boxes-stacked',
            'roles' => [],
        ],
    ],
];
