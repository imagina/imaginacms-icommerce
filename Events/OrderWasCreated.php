<?php

namespace Modules\Icommerce\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// Transformers
use Modules\Icommerce\Transformers\OrderTransformer;

class OrderWasCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $items;

    public function __construct($order,$items)
    {
        $this->order = $order;
        $this->items = $items;

    }

    public function broadcastAs()
    {
        return 'newOrder';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['order-was-created'];
    }

}
