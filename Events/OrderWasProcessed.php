<?php

namespace Modules\Icommerce\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// Transformers
use Modules\Icommerce\Transformers\OrderTransformer;

class OrderWasProcessed
{
  public $order;
  
  public function __construct($order)
  {
    $this->order = $order;
  }
  
 
  
}
