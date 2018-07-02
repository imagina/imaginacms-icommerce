<?php

return [
    'icommerce' => 'Ecommerce',

    'button' => [

    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'title is required'=>'El título es requerido',
        'title min 2'=>'El título debe contener mínimo dos caracteres',
        'description is required'=>'La descripción es requerida',
        'description min 2'=>'La descripción debe contener mínimo dos caracteres',
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
    'slug'=>'Enlace permanente:',
    'description' => 'Descripción',

    'date'      =>  'Fecha y hora',
    'optional'  =>  '(Opcional)',
    
    'summary' => 'Sumario',
    'content' => 'Content',

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
        'tax' => 'Tasa',
        'orderitemsTax' => 'Tasa en OrderItems',
        'emails'=>'Email del Webmaster',
        'fromemail'=>'Email de Remitente',
        'countryTax' => 'Pais donde la tasa sera aplicada',
        'countryDefault' => 'Pais por Defecto',
        'countryFreeshipping' => 'Pais con Productos Freeshipping'
    ],

    'uri' => 'icommerce',

    'emailSubject' => [
        'failed' => 'Transaccion Fallida',
        'complete' => 'Transaccion Completa',
        'refunded' => 'Transaccion Rechazada',
        'pending' => 'Transaccion Pendiente',
        'history' => 'Order Estatus',
    ],

    'emailIntro' => [
        'failed' => 'Reporte del Sistema de Pagos: Transaccion Fallida',
        'complete' => 'Reporte del Sistema de Pagos: Transaccion Completa',
        'refunded' => 'Reporte del Sistema de Pagos: Transaccion Rechazada',
        'pending' => 'Reporte del Sistema de Pagos: Transaccion Pendiente',
        'history' => 'El estatus de la orden ha cambiado',
    ],

    'emailMsg' =>[
        'order' => 'Orden',
        'success' => 'Fue procesada satisfactoriamente',
        'articles' => 'Articulos',
        'comment' => 'Comentario',
    ],
    
    'payuSubject' => [
        'signError' => 'Reporte del Sistema de Pagos: Error en Firma',
    ],

    'payuIntro' => [
        'signError' => 'Reporte del Sistema de Pagos: Error en Firma',
    ],

    'home' => [
        'details' => 'DETALLE',
    ],
    
];
