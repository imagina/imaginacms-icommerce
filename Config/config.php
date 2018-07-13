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
    
    */
    'agree' => [
      'name' => 'icommerceagree',
      'title' => 'icommerceagree::configagrees.single',
      'entity' => '\Modules\IcommerceAgree\Entities\Configagree',
      'view' => 'icommerceagree::admin.configagrees.index',
      'msjini' => 'icommerceagree::configagrees.messages.msjini',
      'init' => "icommerceagree_Init"
    ],
    
    'ups' => [
      'name' => 'icommerceups',
      'title' => 'icommerceups::configups.single',
      'entity' => '\Modules\IcommerceUps\Entities\Configups',
      'view' => 'icommerceups::admin.configups.index',
      'msjini' => 'icommerceups::configups.messages.msjini',
      'init' => "icommerceups_Init"
    ],
    
    'usps' => [
      'name' => 'icommerceusps',
      'title' => 'icommerceusps::configusps.single',
      'entity' => '\Modules\IcommerceUsps\Entities\Configusps',
      'view' => 'icommerceusps::admin.configusps.index',
      'msjini' => 'icommerceusps::configusps.messages.msjini',
      'init' => "icommerceusps_Init"
    ],
  
  ],
  
  'paymentmethods' => [
    
    'icommercepaypal' => [
      'name' => 'icommercepaypal',
      'title' => 'icommercepaypal::paypalconfigs.single',
      'entity' => '\Modules\IcommercePaypal\Entities\Paypalconfig',
      'view' => 'icommercepaypal::admin.paypalconfigs.index'
    ],
    
    'icommercecheckmo' => [
      'name' => 'icommercecheckmo',
      'title' => 'icommercecheckmo::checkmoconfigs.single',
      'entity' => '\Modules\IcommerceCheckmo\Entities\Checkmoconfig',
      'view' => 'icommercecheckmo::admin.checkmoconfigs.index'
    ],
  
  ]

];