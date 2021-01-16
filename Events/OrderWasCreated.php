<?php

namespace Modules\Icommerce\Events;

use Modules\User\Entities\Sentinel\User;

class OrderWasCreated
{

    public $order;
    public $items;
    public $entity;
    public $notificationService;

    public function __construct($order,$items)
    {
        $this->order = $order;
        $this->entity = $order;
        $this->items = $items;
        $this->notificationService = app("Modules\Notification\Services\Inotification");
     
    }
  
  public function notification(){
    
    $subject = trans('icommerce::orders.title.single_order_title')." #".$this->order->id.": ".$this->order->status->title;
    
    $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
    $usersToNotity = json_decode(setting("icommerce::usersToNotify", null, "[]"));

    if(empty($emailTo))
      $emailTo = explode(',', setting('icommerce::form-emails'));
    
    $users = User::whereIn("id",$usersToNotity)->get();

    $emailTo = array_merge($emailTo,$users->pluck('email')->toArray());
  
 
    $this->notificationService->to([
      "email" => $emailTo,
      "broadcast" => $users->pluck('id')->toArray(),
      "push" => $users->pluck('id')->toArray(),
    ])->push(
      [
        "title" => $subject,
        "message" => $subject,
        "icon_class" => "fas fa-shopping-cart",
        "link" => $this->order->frontend_url,
        "content" => "icommerce::emails.order",
        "setting" => [
          "saveInDatabase" => 1 // now, the notifications with type broadcast need to be save in database to really send the notification
        ],
        "order" => $this->order,
        "items" => $this->items,
        "options" => $this->order->orderOption,
      ]
    );
    
    //TODO para cuando se arregle el handler del Notification volver a colocar estas lineas segun la documentación
    /*
    return [
      "title" =>  $subject,
      "message" =>  $subject,
      "icon" => "fas fa-shopping-cart",
      "link" => $this->order->frontend_url,
      "view" => "icommerce::emails.Order",
      "recipients" => [
        "email" => $emailTo,
        "broadcast" => $users->pluck('id')->toArray(),
        "push" => $users->pluck('id')->toArray(),
      ],
      "order" => $this->entity,
      "items" => $this->items
    ];*/
  }

}
