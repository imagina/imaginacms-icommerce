<?php

return [
    'icommerce' => 'Ecommerce',
    'home'      => [
        'title'     => 'Inicio',
        'details'   => 'DETALLES', 
    ], 
    'button' => [
    ],
    'sidebar'       =>[
        'products'              => 'Productos',
        'shipping'              => 'Envío',
        'paymentsanddiscount'   => 'Métodos de pago y descuentos'
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'title is required'         =>'El título es requerido',
        'title min 2'               =>'El título debe contener mínimo dos caracteres',
        'description is required'   =>'La descripción es requerida',
        'description min 2'         =>'La descripción debe contener mínimo dos caracteres',
    ],
    'validation' => [
    ],
    'status' => [
        'draft'         => 'Borrador',
        'pending'       => 'Pendiente de Revisión',
        'published'     => 'Publicado',
        'unpublished'   => 'En espera',
    ],
    'status_text'       => 'Estado',
    'image'             => 'Imágen',
    'categories'        => 'Categorías',
    'title'             => 'Título',
    'slug'              => 'Enlace permanente:',
    'description'       => 'Descripción',
    'date'              => 'Fecha y hora',
    'optional'          => '(Opcional)',
    'summary'           => 'Sumario',
    'content'           => 'Contenido',
    'select'            => 'Select an option',
    'author'            => 'Autor',
    'default_category'  => 'Categoría Principal',
    'admin_notes'       => 'Notas de Administración',
    'created_at'        => 'Fecha de Creación',
    'parent'            => 'Superior',
    'settings' => [
        'couponsQuantity'       => 'Cantidad de Cupones',
        'couponAvailable'       => 'Activar Cupon',
        'codeLenght'            => 'Longitud del codigo (Excluye el Prefijo, Sufijo y Separadores)',
        'couponFormat'          => 'Formato del Cupón',
        'alphanumeric'          => 'Alfanumérico',
        'numeric'               => 'Numérico',
        'alphabetic'            => 'Alfabético',
        'codePrefix'            => 'Prefijo ( Si es necesario)',
        'codeSufix'             => 'Sufijo ( Si es necesario)',
        'dashEvery'             => 'Guión cada carácter x - Ejem: Si el número es 3 el codigo seria xxx-xxx-xxx',
        'tax'                   => 'Tasa',
        'orderitemsTax'         => 'Tasa en OrderItems',
        'emails'                => 'Email del Webmaster',
        'fromemail'             => 'Email de Remitente',
        'countryTax'            => 'Pais donde la tasa sera aplicada',
        'countryDefault'        => 'Pais por Defecto',
        'countryFreeshipping'   => 'Pais con envío gratuito de Productos'
    ],
    'uri'           => 'icommerce',
    'emailSubject'  => [
        'failed'        => 'Transaccion fallida',
        'complete'      => 'Transaccion completa',
        'refunded'      => 'Transaccion rechazada',
        'pending'       => 'Transaccion pendiente',
        'history'       => 'Estado de la orden',
    ],
    'emailIntro'    => [
        'failed'        => 'Reporte del Sistema de Pagos: Transaccion Fallida',
        'complete'      => 'Reporte del Sistema de Pagos: Transaccion Completa',
        'refunded'      => 'Reporte del Sistema de Pagos: Transaccion Rechazada',
        'pending'       => 'Reporte del Sistema de Pagos: Transaccion Pendiente',
        'history'       => 'El estado de la orden ha cambiado',
    ],
    'emailMsg'      =>[
        'order'         => 'Orden',
        'success'       => 'Fue procesada satisfactoriamente',
        'articles'      => 'Articulos',
        'comment'       => 'Comentario',
    ],
    'payuSubject'   => [
        'signError'     => 'Reporte del Sistema de Pagos: Error en Firma',
    ],
    'payuIntro'     => [
        'signError'     => 'Reporte del Sistema de Pagos: Error en Firma',
    ],
    'sort'          => [
        'title'             => 'Ordenar Por',
        'all'               => 'Todas',
        'name_a_z'          => 'Nombre (A - Z)',
        'name_z_a'          => 'Nombre (Z - A)',
        'price_low_high'    => 'Precio: bajo a alto',
        'price_high_low'    => 'Precio alto a bajo',
    ],
    'range'          => [
        'title'             => 'RANGO DE PRECIO',
    ],
    'pagination'    => [
        'previous'          => 'Anterior',
        'next'              => 'Siguiente',
    ],
    'featured_recommended'  => [
        'quick_view'        => 'VISTA RAPIDA',
        'featured'          => 'PROMOCIONADO',
        'recommended'       => 'RECOMENDADO',
    ],
    'search'    => [
        'go'                => 'IR',
        'no_results'        => 'No hay resultados',
        'see_all'           => 'Ver todos los resultados...',
        'search_result'     => 'Resultado de la busqueda de',
    ],
    'related'    => [
        'page'              => 'PAGINA RELACIONADA',
        'unknown'           => 'Lorem ipsum dolor sit amet1',
    ],
    'bulkload'    => [
        'massive_load'      => 'Carga Masiva',
        'pro_cat_bran'      => 'Productos - Categorias - Marcas',
        'load_data'         => 'Cargar data',
    ],
];
