<?php

namespace Modules\Icommerce\Events;

// Transformers
use Modules\Iprofile\Entities\Sentinel\User;

class OrderWasCreated
{

    public $order;
    public $entity;
    public $items;

    public function __construct($order,$items)
    {
        $this->order = $order;
        $this->entity = $order;
        $this->items = $items;

    }
  
  public function notification(){

    $subject = trans('icommerce::orders.title.single_order_title')." #".$order->id.": ".$order->status->title;
    $emailTo = explode(',', $this->setting->get('icommerce::form-emails'));
    $users = User::whereIn("email",$emailTo)->get();
    return [
      "title" =>  "Nueva Orden",
      "message" =>  $subject,
      "icon" => "fas fa-shopping-cart",
      "link" => env('FRONTEND_URL')."/?showEventId=".$this->event->id,
      "view" => "icommerce::emails.Order",
      "recipients" => [
        "email" => $emailTo,
        "broadcast" => $users->pluck('id')->toArray(),
        "push" => $users->pluck('id')->toArray(),
      ],
      "event" => $this->entity
    ];
  }

 

}
