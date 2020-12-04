<?php

namespace Modules\Icommerce\Events;

use Illuminate\Queue\SerializesModels;

class ProductListWasCreated
{
    use SerializesModels;
    public $productList;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($productList)
    {
      $this->productList = $productList;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
