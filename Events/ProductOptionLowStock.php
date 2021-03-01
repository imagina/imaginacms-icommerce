<?php

namespace Modules\Icommerce\Events;

use Modules\User\Entities\Sentinel\User;

class ProductOptionLowStock
{
  public $mails;
  public $product;
  public $notificationService;
  // this attribute it's required
  public $entity;
  
  /**
   * Create a new event instance.
   *
   * @param $entity
   * @param array $data
   */
  public function __construct($mails, $product, $entity)
  {
    $this->mails = $mails;
    $this->product = $product;
    $this->entity = $entity;
    $this->notificationService = app("Modules\Notification\Services\Inotification");
    
    $this->notification();
  }
  
  // this method it's required
  
  public function notification()
  {
    
    
    //Emails from setting form-emails
    $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
    if (empty($emailTo)) //validate if its a string separately by commas
      $emailTo = explode(',', setting('icommerce::form-emails'));
    
    //Emails from users selected in the setting usersToNotify
    $usersToNotity = json_decode(setting("icommerce::usersToNotify", null, "[]"));
    $users = User::whereIn("id", $usersToNotity)->get();
    $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
    
    //send notification by email, broadcast and push -- by default only send by email
    $this->notificationService->to([
      "email" => $emailTo,
      "broadcast" => $users->pluck('id')->toArray(),
      "push" => $users->pluck('id')->toArray(),
    ])->push(
      [
        "title" => trans("icommerce::productoptions.alerts.lowStock"),
        "message" => trans("icommerce::productoptions.messages.lowStock", ["units" => $this->entity->quantity,
          "name" => $this->entity->optionValue->description, "productName" => $this->product->name]),
        "icon_class" => "fas fa-shopping-cart",
        "buttonText" => trans("icommerce::products.edit"),
        "withButton" => true,
        "link" => url('/iadmin/#/ecommerce/products/' . $this->product->id),
        "setting" => [
          "saveInDatabase" => 1 // now, the notifications with type broadcast need to be save in database to really send the notification
        ],
      ]
    );
    
    /*
  return [
    "title" =>  "",
    "message" =>   "",
    "icon_class" => "fas fa-glass-cheers",
    "link" => "link",
    "view" => "iteam::emails.userJoined.userJoined",
    "recipients" => [
      "email" => [$this->mails],
      //"broadcast" => [$this->user->id],
      //"push" => [$this->user->id],
    ],
    
    // here you can send all objects and params necessary to the view template
    "product" => $this->product,
    "entity" => $this->entity,
  ];*/
  }
  
}

