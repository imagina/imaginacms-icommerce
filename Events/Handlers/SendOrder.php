<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\User\Entities\Sentinel\User;
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
  public $notificationService;
  
  public function __construct(Mailer $mail, Notification $notification)
  {
    $this->mail = $mail;
    $this->setting = app('Modules\Setting\Contracts\Setting');
    $this->notification = $notification;
    $this->notificationService = app("Modules\Notification\Services\Inotification");
    
  }
  
  public function handle($event)
  {
    try {
      $order = $event->order;
      
      //Subject
      $subject = trans('icommerce::orders.messages.purchase order') . " #" . $order->id . ": " . $order->status->title;
  
      //Roles to tenant
      $rolesToTenant = json_decode(setting("isite::rolesToTenant",null,"[]"));
  
      // si hay roles asignados a funcionar como tenant entonces el customer de la orden debe ser notificado sólo en las
      // ordenes hijas
      \Log::info('Icommerce: Events|Handlers|SendOrder|RolesToTenant: '.json_encode($rolesToTenant));
      if(!empty($rolesToTenant)){
        // only insert the customer if the order has a parentId
        if(!is_null($order->parent_id)){
          list($emailTo,$users) = $this->getUsersAndEmails($order);
        }
      }else{
        list($emailTo,$users) = $this->getUsersAndEmails($order);
      }
      
      //if there are valid and not empty emailsTo
      if(isset($emailTo) && !empty($emailTo)){
  
        //send notification by email, broadcast and push -- by default only send by email
        $this->notificationService->to([
          "email" => $emailTo,
          "broadcast" => $users->pluck('id')->toArray(),
          "push" => $users->pluck('id')->toArray(),
        ])->push(
          [
            "title" => trans("icommerce::orders.title.confirmation_single_order_title"),
            "message" => $subject,
            "icon_class" => "fas fa-shopping-cart",
            "link" => $order->url,
            "content" => "icommerce::emails.order",
            "view" => "icommerce::emails.Order",
            "setting" => [
              "saveInDatabase" => 1 // now, the notifications with type broadcast need to be save in database to really send the notification
            ],
            "order" => $order
          ]
        );
        
      }
      
      
    } catch (\Exception $e) {
      \Log::error('Icommerce: Events|Handlers|SendOrder|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
    }
    
  }
  
  private function getUsersAndEmails($order){
  
    //Emails from setting form-emails
    $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
    if (empty($emailTo)) //validate if its a string separately by commas
      $emailTo = explode(',', setting('icommerce::form-emails'));
  
    //Emails from users selected in the setting usersToNotify
    $usersToNotify = json_decode(setting("icommerce::usersToNotify", null, "[]"));
    $users = User::whereIn("id", $usersToNotify)->get();
    $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
  
    //By last, gets the Email of the user in the order
    array_push($emailTo, $order->email);
  
    return [$emailTo, $users];
  }
  
  
}
