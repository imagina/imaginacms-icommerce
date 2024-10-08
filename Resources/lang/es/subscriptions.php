<?php

return [
    'list resource' => 'List subscriptions',
    'create resource' => 'Create subscriptions',
    'edit resource' => 'Edit subscriptions',
    'destroy resource' => 'Destroy subscriptions',
    'title' => [
        'subscriptions' => 'Subscription',
        'create subscription' => 'Create a subscription',
        'edit subscription' => 'Edit a subscription',
        'subscription created' => 'Subscripción #:id | Creada',
        'subscription updated' => 'Subscripción #:id | Actualizada'
    ],
    'button' => [
        'create subscription' => 'Create a subscription',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'subscription created' => '<p>Producto: <strong>:title</strong><p>Frecuencia: <strong>:frequency</strong><p>Estado: <strong>:status</strong><p>Metodo de Pago: <strong>:paymentMethod</strong></p><p>Fecha de Vencimiento:  <strong>:dueDate</strong> </p>',
        'subscription updated' => '<p>Producto: <strong>:title</strong><p>Frecuencia: <strong>:frequency</strong><p>Estado: <strong>:status</strong> <p>Metodo de Pago: <strong>:paymentMethod</strong></p><p>Fecha de Vencimiento:  <strong>:dueDate</strong></p>'
    ],
    'validation' => [
    ],
    'status' => [
        'pending' => 'Pendiente',
        'active' => 'Activo',
        'expired' => 'Expirado',
        'suspended' => 'Suspendido',
        'cancelled' => 'Cancelado',
        'failed' => 'Fallido',
        'denied' => 'Denegado',
        'paymentPending' => 'Pago Pendiente'
    ]
];
