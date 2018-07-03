<?php

return [
    'icommerce' => 'Ecommerce',
    'home'      => [
        'title'     => 'Home',
        'details'   => 'DETAILS', 
    ], 
    'button'    => [
    ],
    'sidebar'       =>[
        'products'              => 'Products',
        'shipping'              => 'Shipping',
        'paymentsanddiscount'   => 'Payments And Discount'
    ],
    'table'         => [
    ],
    'form'          => [
    ],
    'messages'      => [
        'title is required'         => 'The title is required',
        'title min 2'               => 'The title must contain at least two characters',
        'description is required'   => 'The description is required',
        'description min 2'         => 'The description must contain at least two characters',
    ],
    'validation'    => [
    ],
    'status'        => [
        'draft'         => 'Draft',
        'pending'       => 'Pending review',
        'published'     => 'Published',
        'unpublished'   => 'Unpublished',
    ],
    'status_text'       => 'Estatus',
    'image'             => 'Image',
    'categories'        => 'Categories',
    'title'             => 'Títle',
    'slug'              => 'Slug',
    'description'       => 'Description',
    'date'              => 'Date and Time',
    'optional'          => '(Optional)',
    'summary'           => 'Sumary',
    'content'           => 'Content',
    'select'            => 'Select an option',
    'author'            => 'Author',
    'default_category'  => 'Default Category',
    'admin_notes'       => 'Admin\'s notes',
    'created_at'        => 'Creation date',
    'parent'            => 'Parent',

    'settings'      => [
        'couponsQuantity'       => 'Coupons quantity',
        'couponAvailable'       => 'Activate coupon',
        'codeLenght'            => 'Code\'s longitude (exclude the prefix, suffix and hyphen)',
        'couponFormat'          => 'Coupon\'s format',
        'alphanumeric'          => 'Alphanumeric',
        'numeric'               => 'Numeric',
        'alphabetic'            => 'Alphabetic',
        'codePrefix'            => 'Prefix (if necessary)',
        'codeSufix'             => 'Suffix (if necessary)',
        'dashEvery'             => 'Hyphen every x character - example: if the number is 3 the code would be xxx-xxx-xxx',
        'tax'                   => 'Tax',
        'emails'                => 'Webmaster - Email',
        'fromemail'             => 'Sender - Email',
        'countryTax'            => 'Country where the tax will be applied',
        'countryDefault'        => 'Default country',
        'countryFreeshipping'   => 'Country with freeshipping'
    ],
    'uri' => 'icommerce',
    'emailSubject'  => [
        'failed'    => 'Failed transaction',
        'complete'  => 'Transaction completed',
        'refunded'  => 'Transaction declined',
        'pending'   => 'Pending transaction',
        'history'   => 'Order status',
    ],
    'emailIntro'    => [
        'failed'    => 'Payment System Report: Failed transaction',
        'complete'  => 'Payment System Report: Transaction completed',
        'refunded'  => 'Payment System Report: Transaction declined',
        'pending'   => 'Payment System Report: Pending transaction',
        'history'   => 'The status of your order has changed',
    ],
    'emailMsg'      =>[
        'order'     => 'Order',
        'success'   => 'It was processed satisfactorily',
        'articles'  => 'Articles',
        'comment'   => 'Comment',
    ],
    'payuSubject'   => [
        'signError' => 'Payment System Report: Signature Error',
    ],
    'payuIntro'     => [
        'signError' => 'Payment System Report: Signature Error',
    ],
];
