<?php

return [
    'icommerce' => 'Ecommerce',
    'home' => [
        'title' => 'Inicio',
        'details' => 'DETALLES',
    ],
    'button' => [
        'update' => 'Update',
    ],
    'sidebar' => [
        'products' => 'Productos',
        'shipping' => 'Envío',
        'paymentsanddiscount' => 'Métodos de pago y descuentos'
    ],
    'table' => [
    ],
    'form' => [
    ],
    'pages' => [
      'index' => 'Index Page',
      'checkout' => 'Checkout Page',
    ],
    'filters' => [
      'title' => 'Filters',
      'categories' => [
          'group' => 'Filter Categories',
          'title' => 'Title'
       ],
      'priceRange' => [
        'group' => 'Filter Price Range',
        'step' => 'Step'
      ],
      'priceList' => [
          'group' => 'Price Lists'
      ],
    ],
    'messages' => [
        'title is required' => 'El título es requerido',
        'title min 2' => 'El título debe contener mínimo dos caracteres',
        'description is required' => 'La descripción es requerida',
        'description min 2' => 'La descripción debe contener mínimo dos caracteres',
        'no products' => 'There are no products available',
        'field required' => 'This field is required',
        'min 2 characters' => 'Minimum of 2 characters',
    ],
    'validation' => [
    ],
    'status' => [
        'draft' => 'Borrador',
        'pending' => 'Pendiente de Revisión',
        'published' => 'Publicado',
        'unpublished' => 'En espera',
    ],
    'status_text' => 'Estado',
    'image' => 'Imágen',
    'categories' => 'Categorías',
    'title' => 'Título',
    'slug' => 'Enlace permanente:',
    'description' => 'Descripción',
    'status' => 'Status',
    'minimum Amount' => 'Minimum amount',
    'date' => 'Fecha y hora',
    'optional' => '(Opcional)',
    'summary' => 'Sumario',
    'content' => 'Contenido',
    'select' => 'Select an option',
    'author' => 'Autor',
    'default_category' => 'Categoría Principal',
    'admin_notes' => 'Notas de Administración',
    'created_at' => 'Fecha de Creación',
    'parent' => 'Superior',
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
        'tax' => 'Impuesto',
        'orderitemsTax' => 'Tasa en OrderItems',
        'emails' => 'Email del Webmaster',
        'usersToNotify' => 'Users to Notify',
        'fromemail' => 'Email',
        'countryTax' => 'Pais donde la tasa sera aplicada',
        'countryDefault' => 'Pais por Defecto',
        'countryFreeshipping' => 'Pais con envío gratuito de Productos',
        'product-per-page' => 'Productos Por Pagina',
        'customIndexTitle' => 'Título Página Index',
        'customIndexDescription' => 'Page Index - Description',
        'filterRangePricesStep' => 'Filtro Rango de Precios - Step',
        'daysEnabledForNewProducts' => 'días habilitados para productos nuevos ',
        'customIndexContactLabel' => 'Title for Contact Button',
        'customCheckoutTitle' => 'Title for Checkout',
        'product'=>[
            'group' => 'Product',
            'layout' => 'Product Layout',
            'minimumQuantityToNotify' => 'Minimum quantity to notify low stock',
        ],
        'product-price-list-enable' => 'Enable',
        'product-add-to-cart-with-quantity' => 'Add to Cart with quantity (Product Item)',
        'cart' => [
          'group' => 'Cart',
          'canAddIsCallProductsIntoCart' => 'Can Add Is Call Products Into Cart'
        ]
    ],
    'settingHints' => [
        'emails' => "Type the email and press enter key"
    ],
    'uri' => 'icommerce',
    'emailSubject' => [
        'failed' => 'Transaccion fallida',
        'complete' => 'Transaccion completa',
        'refunded' => 'Transaccion rechazada',
        'pending' => 'Transaccion pendiente',
        'history' => 'Estado de la orden',
    ],
    'emailIntro' => [
        'failed' => 'Payment System report: Transaction Failed',
        'complete' => 'Payment System report: Transaction Completed',
        'refunded' => 'Payment System report: Transaction Rejected',
        'pending' => 'Payment System report: Transaction Pending',
        'history' => 'El estado de la orden ha cambiado',
    ],
    'emailMsg' => [
        'order' => 'Order',
        'success' => 'Was proccessed successfully',
        'articles' => 'Articles',
        'comment' => 'Comment',
        'orderurl' => 'If you wish to see your order status at any time, please go to the next link: '
    ],
    'payuSubject' => [
        'signError' => 'Payment System report: Signature Error',
    ],
    'payuIntro' => [
        'signError' => 'Payment System report: Signature Error',
    ],
    'sort' => [
        'title' => 'Order by',
        'all' => 'All',
        'name_a_z' => 'Name (A - Z)',
        'name_z_a' => 'Name (Z - A)',
        'price_low_high' => 'Price: lower to higher',
        'price_high_low' => 'Price: higher to lower',
        'recently' => 'More Recently',
    ],
    'range' => [
        'title' => 'Price Range',
    ],
    'product-type' => [
        'title' => 'Product Type',
        'searchable' => 'Searchable',
        'affordable' => 'Afrrodable'
    ],
    'pagination' => [
        'previous' => 'Anterior',
        'next' => 'Siguiente',
    ],
    'featured_recommended' => [
        'quick_view' => 'VISTA RAPIDA',
        'featured' => 'PROMOCIONADO',
        'recommended' => 'RECOMENDADO',
    ],
    'search' => [
        'go' => 'IR',
        'no_results' => 'No hay resultados',
        'see_all' => 'Ver todos los resultados...',
        'search_result' => 'Resultado de la busqueda de',
    ],
    'related' => [
        'page' => 'PAGINA RELACIONADA',
        'unknown' => 'Lorem ipsum dolor sit amet1',
    ],
    'bulkload' => [
        'massive_load' => 'Carga Masiva',
        'pro_cat_bran' => 'Productos - Categorias - Marcas',
        'load_data' => 'Cargar data',
    ],
    'email' => [
        'subject' => 'Transaction Status:',
        'intro' => 'Payment System Report',
        'msg' => [
            'order' => 'Order',
            'success' => 'processed',
            'articles' => 'Articles',
            'comment' => 'Comment',
            'orderurl' => 'If you want to check the status of your order at any time please go to the link: '
        ],
    ],

    'social' => [
        'share' => 'Share'
    ],

];
