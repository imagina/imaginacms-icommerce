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
      try{
        $order = $event->order;

        //TODO @carlosdevia mejorar este mensaje mas amigable par ael cliente
        $subject = trans('icommerce::orders.title.single_order_title')." #".$order->id.": ".$order->status->title;
        $view = "icommerce::emails.Order";
   
        // OJO DESCOMENTAR LUEGO
        //TODO 27082020 agregar variables en el ENV que inidique en qué entorno se encuetra para validar esta línea que no debiera estar descomentandose ni comentandose
        $this->mail->to($order->email)->send(new Order($order,$subject,$view));
  
        //TODO 2708220 esta linea no sirve para nada, no existe un user_id en el store
        // $this->notification->to($order->store->user_id)->push('Nueva Orden de compra', $subject,'fas fa-store', '/admin/stores/my-store/order/'.$order->id);
  
        $email_to = explode(',', $this->setting->get('icommerce::form-emails'));
      
        $subject = trans('icommerce::orders.title.single_order_title')." #".$order->id.": ".$order->status->title;
        $this->mail->to($email_to)->send(new Order($order,$subject,$view));
  
      }catch(\Exception $e){
        \Log::error("Error | SendOrder Event: ".$e->getMessage()."\n".$e->getFile()."\n".$e->getLine().$e->getTraceAsString());
      }
      
    }

    

}
