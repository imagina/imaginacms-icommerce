<?php



return [

    'name' => 'Icommerce',

    'comments' => false,

    'shippingmethods' => [

        /*
    	'freeshipping'=> [
    		'name' => 'freeshipping',
    		'title' => trans('ifreeshipping::configurations.single') ,
    		'entity' => '\Modules\Icommerce_freeshipping\Entities\Configuration',
    		'view' => 'ifreeshipping::admin.configurations.index'
    	],
        */

        /*
        'flatrate'=> [
            'name' => 'flatrate',
            'title' => trans('iflatrate::configflatrates.single') ,
            'entity' => '\Modules\Icommerce_flatrate\Entities\Configflatrate',
            'view' => 'iflatrate::admin.configflatrates.index',
            'msjini' => trans('iflatrate::configflatrates.messages.msjini'),
            'init' => "iflatrate_Init"
        ],
        */


        /*
        'localdelivery'=> [
            'name' => 'localdelivery',
            'title' => trans('ilocaldelivery::configlocaldeliveries.single') ,
            'entity' => '\Modules\Ilocaldelivery\Entities\Configlocaldelivery',
            'view' => 'ilocaldelivery::admin.configlocaldeliveries.index'
        ],
        */

        'iagree'=> [
            'name' => 'iagree',
            'title' => trans('iagree::configagrees.single') ,
            'entity' => '\Modules\Icommerce_agree\Entities\Configagree',
            'view' => 'iagree::admin.configagrees.index',
            'msjini' => trans('iagree::configagrees.messages.msjini'),
            'init' => "iagree_Init"
        ],

        'ups'=> [
            'name' => 'ups',
            'title' => trans('iups::configups.single') ,
            'entity' => '\Modules\Icommerce_ups\Entities\Configups',
            'view' => 'iups::admin.configups.index',
            'msjini' => trans('iups::configups.messages.msjini'),
            'init' => "iups_Init"
        ],

        'usps'=> [
            'name' => 'usps',
            'title' => trans('iusps::configusps.single') ,
            'entity' => '\Modules\Icommerce_usps\Entities\Configusps',
            'view' => 'iusps::admin.configusps.index',
            'msjini' => trans('iusps::configusps.messages.msjini'),
            'init' => "iusps_Init"
        ],

    ],

    'paymentmethods' => [

        'paypal'=> [
            'name' => 'paypal',
            'title' => trans('ipaypal::paypalconfigs.single') ,
            'entity' => '\Modules\Icommerce_paypal\Entities\Paypalconfig',
            'view' => 'ipaypal::admin.paypalconfigs.index'
        ],

        'checkormoney'=> [
            'name' => 'checkormoney',
            'title' => trans('icheckmoney::checkmoneyconfigs.single') ,
            'entity' => '\Modules\Icommerce_checkmoney\Entities\Checkmoneyconfig',
            'view' => 'icheckmoney::admin.checkmoneyconfigs.index'
        ],

    ]

];
