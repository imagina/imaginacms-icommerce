<?php

namespace Modules\Icommerce\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Modules\Icommerce\Repositories\OrderRepository;

class OrderSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->view('icommerce::emails.OrderSuccess')
            ->subject(trans('icommerce::messages.welcome'));
    }
}
