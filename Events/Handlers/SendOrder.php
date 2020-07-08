<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;

use Modules\Icommerce\Emails\Order;
use Modules\Notification\Services\Notification;

class SendOrder
{

    /**
     * @var Mailer
     */
    private $mail;
    private $setting;
    private $notification;

    public function __construct(Mailer $mail, Notification $notification)
    {
        $this->mail = $mail;
        $this->setting = app('Modules\Setting\Contracts\Setting');
        $this->notification = $notification;
    }

    public function handle($event)
    {
        $order = $event->order;

        $subject = trans("icommerce::common.email.subject")." ".$order->status->title." #".$order->id."-".time();
        $view = "icommerce::emails.Order";

        // OJO DESCOMENTAR LUEGO
        $this->mail->to($order->email)->send(new Order($order,$subject,$view));
        $this->notification->push('Nueva Orden de compra', $subject,'fas fa-store', '/admin/stores/my-store/order/'.$order->id);

        $email_to = explode(',', $this->setting->get('icommerce::form-emails'));

        $this->mail->to($email_to)->send(new Order($order,$subject,$view));

    }



}
