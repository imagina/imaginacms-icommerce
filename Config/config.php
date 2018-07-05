<?php



return [

    'name' => 'Icommerce',

    'comments' => false,

    'shippingmethods' => [

        /*
    	'freeshipping'=> [
    		'name' => 'freeshipping',
    		'title' => trans('ifreeshipping::configurations.single') ,
    		'entity' => '\Modules\Ifreeshipping\Entities\Configuration',
    		'view' => 'ifreeshipping::admin.configurations.index'
    	],
        */

        /*
        'flatrate'=> [
            'name' => 'flatrate',
            'title' => trans('iflatrate::configflatrates.single') ,
            'entity' => '\Modules\Iflatrate\Entities\Configflatrate',
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
        

        'icommerceagree'=> [
            'name' => 'icommerceagree',
            'title' => trans('icommerceagree::configagrees.single') ,
            'entity' => '\Modules\IcommerceAgree\Entities\Configagree',
            'view' => 'icommerceagree::admin.configagrees.index',
            'msjini' => trans('icommerceagree::configagrees.messages.msjini'),
            'init' => "icommerceagree_Init"
        ],
        */

        'agree'=> [
            'name' => 'icommerceagree',
            'title' => trans('icommerceagree::configagrees.single') ,
            'entity' => '\Modules\IcommerceAgree\Entities\Configagree',
            'view' => 'icommerceagree::admin.configagrees.index',
            'msjini' => trans('icommerceagree::configagrees.messages.msjini'),
            'init' => "icommerceagree_Init"
        ],

        'ups'=> [
            'name' => 'icommerceups',
            'title' => trans('icommerceups::configups.single') ,
            'entity' => '\Modules\IcommerceUps\Entities\Configups',
            'view' => 'icommerceups::admin.configups.index',
            'msjini' => trans('icommerceups::configups.messages.msjini'),
            'init' => "icommerceups_Init"
        ],

        /*
        'usps'=> [
            'name' => 'usps',
            'title' => trans('iusps::configusps.single') ,
            'entity' => '\Modules\Iusps\Entities\Configusps',
            'view' => 'iusps::admin.configusps.index',
            'msjini' => trans('iusps::configusps.messages.msjini'),
            'init' => "iusps_Init"
        ],
        */

    ],

    'paymentmethods' => [

        'paypal'=> [
            'name' => 'paypal',
            'title' => trans('ipaypal::paypalconfigs.single') ,
            'entity' => '\Modules\Ipaypal\Entities\Paypalconfig',
            'view' => 'ipaypal::admin.paypalconfigs.index'
        ],

        'checkormoney'=> [
            'name' => 'checkormoney',
            'title' => trans('icheckmoney::checkmoneyconfigs.single') ,
            'entity' => '\Modules\Icheckmoney\Entities\Checkmoneyconfig',
            'view' => 'icheckmoney::admin.checkmoneyconfigs.index'
        ],

    ]

];