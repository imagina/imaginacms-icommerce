<?php

return [
    'title'				=> 'Shopping Cart',
    'breadcrumb_title'	=> 'Cart',
    'table'         => [
        'item'          	=> 'Item',
        'sku'          		=> 'SKU',
        'unit_price'        => 'Unit Price',
        'quantity'          => 'Quantity',
        'subtotal'          => 'Sub Total',
        'total'          	=> 'Total: ',
    ],
    'button'    => [
        'continue_shopping'   	=> 'Continue Shopping',
        'proceed_to_checkout'   => 'Proceed To Checkout',
    ],
    'empty_cart_message'    => [
        'part_1'   	=> 'You have no items in your shopping cart. Click ',
        'part_2'   => 'here',
        'part_3'   => ' to continue shopping.',
    ],
    'message' 	=> [
        'add' 			=> 'Product added to the cart',
        'can_not_add' 	=> 'You must add at least one product',
        'not_existence' => 'No more item can be added since it exceeds the inventory\'s existence',
        'min_exceeded' 	=> 'The quantity can\'t be less than 0',
    ],
];