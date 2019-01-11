<?php

namespace Modules\Icommerce\Events;

class OrderWasUpdated
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}