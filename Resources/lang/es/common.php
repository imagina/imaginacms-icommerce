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
  'pages' => [
    'index' => 'Página Principal'
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

  'messages' => [
    'title is required' => 'El título es requerido',
    'title min 2' => 'El título debe contener mínimo dos caracteres',
    'description is required' => 'La descripción es requerida',
    'description min 2' => 'La descripción debe contener mínimo dos caracteres',
    'no products' => 'No existen productos disponibles',
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
  'status' => 'Estado',
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
    'emails' => 'Emails para enviar notificaciones',
    'usersToNotify' => 'Usuarios para enviar notificaciones',
    'fromemail' => 'Email',
    'countryTax' => 'Pais donde la tasa sera aplicada',
    'countryDefault' => 'Pais por Defecto',
    'countryFreeshipping' => 'Pais con envío gratuito de Productos',
    'product-per-page' => 'Productos Por Pagina',
    'customIndexTitle' => 'Título Página Index',
    'filterRangePricesStep' => 'Filtro Rango de Precios - Step',
    'daysEnabledForNewProducts' => 'días habilitados para productos nuevos ',
    'product'=>[
      'group' => 'Producto',
      'layout' => 'Layout del Producto',
      'minimumQuantityToNotify' => 'Cantidad mínima para notificar inventario bajo',
    ],
    'product-price-list-enable' => 'Activar',
    'product-add-to-cart-with-quantity' => 'Agregar al carrito con cantidad(Product Item)',

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

];
