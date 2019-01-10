<?php

namespace Modules\Icommerce\Events;

class OrderWasCreated
{
    public $order;

    public function __construct($order)
    {
        \Log::info('Ingreso a OrderWasCreated');
        $this->order = $order;
    }
}