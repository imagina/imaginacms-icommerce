<?php

namespace Modules\Icommerce\Events;

class OrderWasCreated
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}