<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;

use Modules\Icommerce\Emails\Order;

class SendOrder
{
   
    /**
     * @var Mailer
     */
    private $mail;
    private $setting;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
        $this->setting = app('Modules\Setting\Contracts\Setting');
    }

    public function handle($event)
    {
        $order = $event->order;
        
        $subject = trans("icommerce::common.email.subject")." ".$order->status->title." #".$order->id."-".time();
        $view = "icommerce::emails.Order";

        // OJO DESCOMENTAR LUEGO
        //$this->mail->to($order->email)->send(new Order($order,$subject,$view));

        $email_to = explode(',', $this->setting->get('icommerce::form-emails'));

        $this->mail->to($email_to[0])->send(new Order($order,$subject,$view));

    }

    

}
