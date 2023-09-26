<?php

namespace Modules\Icommerce\Events;

class OrderIsCreating
{
    public $order;

    public $items;

    public function __construct($order, $items)
    {
        $this->order = $order;
        $this->items = $items;
    }
}
