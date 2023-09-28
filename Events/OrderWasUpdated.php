<?php

namespace Modules\Icommerce\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Transformers

class OrderWasUpdated /*implements ShouldBroadcast*/
{
    //use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function broadcastAs()
    {
        return 'orderUpdated'.$this->order->id;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('global');
    }
}
