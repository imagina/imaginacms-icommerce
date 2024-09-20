<?php

namespace Modules\Icommerce\Events;

// Transformers

class OrderWasProcessed
{
  public $order;

  public function __construct($order)
  {
    $this->order = $order;
  }
}
