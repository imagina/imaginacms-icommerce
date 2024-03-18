<?php

namespace Modules\Icommerce\Events;

use Modules\User\Entities\Sentinel\User;

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
