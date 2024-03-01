<?php

return [
  'icommerce' => 'Ecommerce',
  'home' => [
    'title' => 'Inicio',
    'details' => 'DETALLES',
  ],
  'button' => [
    'update' => 'Actualizar'
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
  'formFields' => [
    'mode' => 'Modo',
    'minimum Amount' => 'Monto Minimo',
    'maximum Amount' => 'Monto Maximo',
    'excludedUsersForMaximumAmount' => 'Usuarios excluidos del monto máximo',
  ],
  'pages' => [
    'index' => 'Página Principal',
    'checkout' => 'Página Checkout',
    'labelDefaultTypeCustomer' => 'Comprar como usuario invitado por defecto',
    'labelEnableGuestShopping' => 'Habilitar la funcionalidad "Comprar como invitado"',
    'buttonChangeShippingAddressWarehouse' => 'Cambiar dirección de entrega',
    'buttonChangeShippingMethodWarehouse' => 'Cambiar Método de envío',
  ],
  'filters' => [
    'title' => 'Filtrar',
    'categories' => [
      'group' => 'Filtro Categorias',
      'title' => 'Titulo'
    ],
    'priceRange' => [
      'group' => 'Filtro Rango de Precios',
      'step' => 'Saltos'
    ],
    'priceList' => [
      'group' => 'Listas de Precios'
    ],
  ],
  'layouts' => [
    'group_name' => 'Plantillas',
    'label_products' => 'Plantilla para Productos De Tienda',
    'label_categories' => 'Plantilla para Categorías De Tienda',
    'label_products_default' => 'Plantilla para Productos De Tienda (Por Defecto)',
    'label_categories_default' => 'Plantilla para Categorías De Tienda (Por Defecto)',
    'titlePostRecent' => 'Artículos recientes',
    'viewMore' => 'Ver más',
    'titleRelatedPosts' => 'Artículos relacionados',
    'titleArticles' => 'Artículos',
  ],
  'messages' => [
    'field required' => 'El campo es requerido',
    'min 2 characters' => 'El campo debe contener mínimo dos caracteres',
    'title is required' => 'El título es requerido',
    'title min 2' => 'El título debe contener mínimo dos caracteres',
    'description is required' => 'La descripción es requerida',
    'description min 2' => 'La descripción debe contener mínimo dos caracteres',
    'no products' => 'No existen productos disponibles',
  ],
  'validation' => [
    'maximumAmount' => "El Monto de la orden excede el máximo permitido (:maximumAmount) para este método de pago",
    'minimumAmount' => "El Monto de la orden debe ser mayor a: (:minimumAmount) para este método de pago"
  ],
  'status' => [
    'draft' => 'Borrador',
    'pending' => 'Pendiente de Revisión',
    'published' => 'Publicado',
    'unpublished' => 'En espera',
  ],
  'status_text' => 'Estado',
  'download' => 'Descargar',
  'image' => 'Imágen',
  'categories' => 'Categorías',
  'title' => 'Título',
  'slug' => 'Enlace permanente:',
  'description' => 'Descripción',
  'status' => 'Estado',
  'minimum Amount' => 'Monto Minimo',
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
  'to' => 'a',
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
    'emails' => 'Emails para enviar notificaciones',
    'usersToNotify' => 'Usuarios para enviar notificaciones',
    'fromemail' => 'Email',
    'countryTax' => 'Pais donde la tasa sera aplicada',
    'countryDefault' => 'Pais por Defecto',
    'countryFreeshipping' => 'Pais con envío gratuito de Productos',
    'product-per-page' => 'Productos Por Pagina',
    'customIndexTitle' => 'Título Página Index',
    'customIndexDescription' => 'Descripción Página Index',
    'filterRangePricesStep' => 'Filtro Rango de Precios - Step',
    'daysEnabledForNewProducts' => 'días habilitados para productos nuevos ',
    'customIndexContactLabel' => 'Título para el Botón de Contacto',
    'customCheckoutTitle' => 'Título para el Checkout',
    'icommerceCartQuoteForm' => 'Formulario para Registro de Cotización',
    'letMeKnowProductIsAvailableForm' => 'Formulario para Avisar cuando un Producto esté disponible',
    'chatByOrderEnable' => 'Habilitar chat por orden de compra',
    'productImageBorder' => 'Activar Borde en Imágen',
    'productImageBorderColor' => 'Color para el Borde en Imágen',
    'productImageBorderRadius' => 'Radio para el Borde en Imágen',
    'productExternalPadding' => 'Espaciado Externo',
    'productExternalBorder' => 'Borde Externo',
    'productExternalBorderRadius' => 'Borde Radio Externo',
    'productExternalBorderColor' => 'Color Borde Externo',
    'productExternalShadowOnHover' => 'Activar Sombra externa en mousehover',
    'productExternalShadowOnHoverColor' => 'Color Sombra externa en mousehover',
    'productWithTextInAddToCart' => 'Activar Texto en botón Añadir',
    'productWithIconInAddToCart' => 'Activar Icono en botón Añadir',
    'productShowButtonsOnMouseHover' => 'Mostrar Botones en Hover',
    'productContentExternalPaddingX' => 'Espaciado en X del Contenido',
    'productContentExternalPaddingY' => 'Espaciado en Y del Contenido',
    'productAddToCartWithQuantityPaddingX' => 'Espaciado en X del Añadir con cantidad',
    'productAddToCartWithQuantityPaddingY' => 'Espaciado en Y del Añadir con cantidad',
    'productAddToCartWithQuantityMarginBottom' => 'Margen inferior del Añadir con cantidad',
    'productContentTitleFontSize' => 'Tamaño del Título',
    'productContentTitleToUppercase' => 'Activar Mayúsculas para el Título',
    'productContentCategoryFontSize' => 'Tamaño de la categoría',
    'productContentCategoryToUppercase' => 'Activar Mayúsculas para la categoría',
    'productContentCategoryEnable' => 'Mostrar Categoría',
    'productContentPriceFontSize' => 'Tamaño del Precio',
    'productContentTitleNumberOfCharacters' => 'Cantidad de caracteres para el título',
    'productContentTitleMaxHeight' => 'Altura máxima/Mínima para el título',
    'productWishlistEnable' => 'Habilitar botón wishlist',
    'productProductBackgroundColor' => 'Color de Fondo General',
    'productRibbonBackgroundColor' => 'Color Fondo de Descuento',
    'productRibbonTextColor' => 'Color Texto de Descuento',
    'productContentPriceFontWeight' => 'Precio Negrita (Weight)',
    'productContentTitleFontWeight' => 'Título Negrita (Weight)',
    'productContentCategoryFontWeight' => 'Categoría Negrita (Weight)',
    'labelOrderSummaryDescription' => 'Información Resumen De La Orden',
    'checkoutRedirectUrl' => 'Ruta para redirigir luego del Checkout',
    'productImageObjectFit' => 'Ajuste de la imagen',
    'warehouse' => [
      'groupName' => 'Bodegas',
      'warehouseFunctionality' => 'Activar funcionalidad para Bodegas',
    ],
    'tenant' => [
      'group' => 'Inquilinos',
      'tenantWithCentralData' => 'Entidades con data central',
      'entities' => [
        'products' => 'Productos',
        'categories' => 'Categorías',
        'carts' => 'Carritos',
        'paymentMethods' => 'Métodos de Pago',
        'shippingMethods' => 'Métodos de Envío',
        'orders' => 'Ordenes',
      ],
    ],
    'product' => [
      'group' => 'Producto',
      'layout' => 'Layout del Producto',
      'minimumQuantityToNotify' => 'Cantidad mínima para notificar inventario bajo',
      'showButtonToQuoteInStore' => 'Mostrar boton para cotizar en la tienda',
      'addToCartQuoteButtonAction' => 'Acción del botón añadir a la cotización',
      'addToCartButtonAction' => 'Acción del botón añadir al carrito',
      'showButtonThatGeneratesPdfOfTheCart' => 'Mostrar botón que genera un PDF del carrito',
      'showReviewsProduct' => 'Mostrar revisiones del producto',
      'showRatingProduct' => 'Mostrar rating del producto',
      'showRatingInReviewsProduct' => 'Mostrar rating en las revisiones del producto',
    ],
    'product-price-list-enable' => 'Activar',
    'product-add-to-cart-with-quantity' => 'Agregar al carrito con cantidad (Product Item)',
    'cart' => [
      'group' => 'Carrito',
      'canAddIsCallProductsIntoCart' => 'Habilitar añadir productos para cotizar al carrito'
    ]

  ],
  'settingHints' => [
    'emails' => "Ingresa el correo y presiona enter"
  ],
  'uri' => 'icommerce',
  'emailSubject' => [
    'failed' => 'Transaccion fallida',
    'complete' => 'Transaccion completa',
    'refunded' => 'Transaccion rechazada',
    'pending' => 'Transaccion pendiente',
    'history' => 'Estado de la orden',
  ],
  'crudFields' => [
    'categoryIndexDescription' => 'Descripción - Página Index'
  ],
  'emailIntro' => [
    'failed' => 'Reporte del Sistema de Pagos: Transaccion Fallida',
    'complete' => 'Reporte del Sistema de Pagos: Transaccion Completa',
    'refunded' => 'Reporte del Sistema de Pagos: Transaccion Rechazada',
    'pending' => 'Reporte del Sistema de Pagos: Transaccion Pendiente',
    'history' => 'El estado de la orden ha cambiado',
  ],
  'emailMsg' => [
    'order' => 'Orden',
    'success' => 'Fue procesada satisfactoriamente',
    'articles' => 'Articulos',
    'comment' => 'Comentario',
    'orderurl' => 'Puede seguir el estado de su orden en cualquier momento a través del siguiente link: ',
    'order-notification' => 'Notificación de estado de la orden'
  ],
  'payuSubject' => [
    'signError' => 'Reporte del Sistema de Pagos: Error en Firma',
  ],
  'payuIntro' => [
    'signError' => 'Reporte del Sistema de Pagos: Error en Firma',
  ],
  'sort' => [
    'title' => 'Ordenar Por',
    'all' => 'Todas',
    'name_a_z' => 'Nombre (A - Z)',
    'name_z_a' => 'Nombre (Z - A)',
    'price_low_high' => 'Precio: bajo a alto',
    'price_high_low' => 'Precio alto a bajo',
    'recently' => 'Más Recientes',
  ],
  'range' => [
    'title' => 'Rango de Precio',
  ],
  'product-type' => [
    'title' => 'Tipo de Producto',
    'searchable' => 'Consultable',
    'affordable' => 'Comprable'
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
    'title' => 'Busqueda de productos',
    'go' => 'IR',
    'no_results' => 'No hay resultados',
    'see_all' => 'Ver todos los resultados...',
    'search_result' => 'Resultado de la busqueda de',
    'settings' => [
      'groupName' => 'Motor De Búsqueda Tienda',
      'labelSearcherOrder' => 'Ordenamiento de búsqueda',
      'labelSearchFields' => 'Campos de búsqueda para productos',
      'options' => [
        'name' => 'Nombre Del Producto',
        'summary' => 'Resumen Del Producto',
        'description' => 'Descripción Del Producto',
        'uniqueWord' => 'Palabras Individuales',
        'createDate' => 'Fecha De Creación',
        'fullWord' => 'Palabra Completa',
      ],
    ],
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
    'share' => 'Compartir'
  ],
  'offers' => [
    'title' => 'Ofertas'
  ],
  'featured' => [
    'title' => 'Productos Destacados'
  ],
  'components' => [
    'buttonLivewire' => [
      'labelDisable' => 'No Disponible',
      'labelLoading' => 'Cargando',
    ],
    'alerts' => [
      'updateCartByDeleteProductWarehouse' => 'Hemos Actualizado tu compra De acuerdo a la disponibilidad en la bodega seleccionada',
      'updateCartByDeleteProduct' => 'Hemos Actualizado tu compra de acuerdo a la disponibilidad del Producto',
    ],
  ],
];
