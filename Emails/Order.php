<?php

namespace Modules\Icommerce\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Modules\Icommerce\Repositories\OrderRepository;

class Order extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $subject;
    public $view;

    public function __construct($order,$subject,$view)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->view($this->view)
            ->subject($this->subject);
    }
}
