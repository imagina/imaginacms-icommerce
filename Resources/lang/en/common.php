<?php

return [
    'icommerce' => 'Ecommerce',

    'button' => [

    ],

    'sidebar'=>[
        'products'=>'Products',
        'shipping'=> 'Shipping',
        'paymentsanddiscount'=>'Payments And Discount'

    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'title is required'=>'The title is required',
        'title min 2'=>'Title must contain at least two characters',
        'description is required'=>'Description is required',
        'description min 2'=>'The description must contain at least two characters',
    ],
    'validation' => [
    ],
    'status' => [
        'draft' => 'Draft',
        'pending' => 'Pending review',
        'published' => 'Published',
        'unpublished' => 'Unpublished',
    ],

    'status_text' => 'Estatus',

    'image' => 'Image',

    'categories' => 'Categories',

    'title' => 'Títle',
    'slug'=>'Slug',
    'description' => 'Description',

    'date'      =>  'Date and Time',
    'optional'  =>  '(Optional)',

    'summary' => 'Sumary',
    'content' => 'Content',

    'select' => 'Select an option',

    'author' => 'Author',

    'default_category' => 'Default Category',

    'admin_notes' => 'Admin`s notes',
    'created_at' => 'Creation date',
    'parent' => 'Parent',

    'settings' => [
        'couponsQuantity' => 'Cantidad de Cupones',
        'couponAvailable' => 'Activar Cupon',
        'codeLenght' => 'Longitud del codigo (Excluye el Prefijo, Sufijo y Separadores)',
        'couponFormat' => 'Formato del Cupón',
        'alphanumeric' => 'Alfanumérico',
        'numeric' => 'Numérico',
        'alphabetic' => 'Alfabético',
        'codePrefix' => 'Prefijo ( Si es necesario)',
        'codeSufix' => 'Sufijo ( Si es necesario)',
        'dashEvery' => 'Guión cada carácter x - Ejem: Si el número es 3 el codigo seria xxx-xxx-xxx',
        'tax' => 'Tax',
        'emails'=>'Webmaster - Email',
        'fromemail'=>'Sender - Email',
        'countryTax' => 'Country where the tax will be applied',
        'countryDefault' => 'Default Country',
        'countryFreeshipping' => 'Country with Products Freeshipping'
    ],

    'uri' => 'icommerce',

    'emailSubject' => [
        'failed' => 'Failed Transaction',
        'complete' => 'Complete Transaction',
        'refunded' => 'Transaction declined',
        'pending' => 'Pending Transaction',
        'history' => 'Status Order',
    ],

    'emailIntro' => [
        'failed' => 'Payment System Report: Failed Transaction',
        'complete' => 'Payment System Report: Complete Transaction',
        'refunded' => 'Payment System Report: Declined Transaction',
        'pending' => 'Payment System Report: Pending Transaction',
        'history' => 'The status of your order has changed',
    ],

    'emailMsg' =>[
        'order' => 'Order',
        'success' => 'It was processed satisfactorily',
        'articles' => 'Articles',
        'comment' => 'Comment',
    ],

    'payuSubject' => [
        'signError' => 'Payment System Report: Signature Error',
    ],

    'payuIntro' => [
        'signError' => 'Payment System Report: Signature Error',
    ],

    'home' => [
        'details' => 'DETAILS',
    ],

];
