<?php

return [
    
    'tax' => [
        'description'  => 'icommerce::common.settings.tax',
        'view'         => 'text',
        'default'      => 0,
        'translatable' => false
    ],

    'country-default' => [
        'description'  => 'icommerce::common.settings.countryDefault',
        'view'         => 'icommerce::admin.fields.setting_select',
        'name'         => 'select_countries',
        'default'      => "0",
        'translatable' => false
    ],

    'country-freeshipping' => [
        'description'  => 'icommerce::common.settings.countryFreeshipping',
        'view'         => 'icommerce::admin.fields.setting_select',
        'name'         => 'select_freeshipping',
        'default'      => "0",
        'translatable' => false
    ],
    /*
    'coupon-available' => [
        'description'  => 'icommerce::common.settings.couponAvailable',
         'options' => [
               'NO' => 'NO',
               'YES' => 'YES'
           ],
        'view' => 'icommerce::admin.fields.setting_radio',
        'default' => 'NO',
        'translatable' => false
    ],
    'code-length' => [
        'description'  => 'icommerce::common.settings.codeLenght',
        'view'         => 'number',
        'default'      => 8,
        'translatable' => false
    ],
    'coupon-format' => [
        'description'  => 'icommerce::common.settings.couponFormat',
         'options' => [
		       'alphanumeric' => 'icommerce::common.settings.alphanumeric',
		       'numeric' => 'icommerce::common.settings.numeric',
		       'alphabetic' => 'icommerce::common.settings.alphabetic',
		   ],
        'view' => 'icommerce::admin.fields.setting_radio',
        'translatable' => false
    ],
    'code-prefix' => [
        'description'  => 'icommerce::common.settings.codePrefix',
        'view'         => 'text',
        'translatable' => false
    ],
    'code-sufix' => [
        'description'  => 'icommerce::common.settings.codeSufix',
        'view'         => 'text',
        'translatable' => false
    ],
    'dash-every' => [
        'description'  => 'icommerce::common.settings.dashEvery',
        'view'         => 'number',
        'default'      => 4,
        'translatable' => false
    ],
    */
   
     'from-email' => [
        'description'  => 'icommerce::common.settings.fromemail',
        'view'         => 'text',
        'translatable' => false,
    ],

    'form-emails' => [
        'description'  => 'icommerce::common.settings.emails',
        'view'         => 'text',
        'translatable' => false,
    ],
   
   

    
];