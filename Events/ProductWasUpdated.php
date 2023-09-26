<?php

namespace Modules\Icommerce\Events;

use Illuminate\Queue\SerializesModels;

class ProductWasUpdated
{
    use SerializesModels;

    public $entity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
