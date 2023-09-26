<?php

namespace Modules\Icommerce\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    public $subject;

    public $view;

    public $dataSend;

    public function __construct($order, $subject, $view, $dataSend)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->view = $view;
        $this->dataSend = $dataSend;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $message = $this->view($this->view)
            ->subject($this->subject);
        if (isset($this->dataSend->from) && isset($this->dataSend->fromName)) {
            $message->from($this->dataSend->from, $this->dataSend->fromName);
        }
        if (isset($this->dataSend->replyTo) && isset($this->dataSend->replyToName)) {
            $message->replyTo($this->dataSend->replyTo, $this->dataSend->replyToName);
        }

        return $message;
    }
}
