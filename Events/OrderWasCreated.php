<?php

namespace Modules\Order\Events;

class OrderWasCreated
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}