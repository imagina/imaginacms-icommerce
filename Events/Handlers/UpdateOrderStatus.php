<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\Icommerce\Entities\Order;
use Illuminate\Contracts\Mail\Mailer;
use Modules\Icommerce\Emails\OrderNotification;
use Modules\Notification\Services\Notification;
use Modules\User\Entities\Sentinel\User;

class UpdateOrderStatus
{
  
  /**
   * @var Mailer
   */
  private $mail;
  private $setting;
  private $notification;
  
  public function __construct(Mailer $mail)
  {
    $this->mail = $mail;
    $this->setting = app('Modules\Setting\Contracts\Setting');
    $this->notification = app("Modules\Notification\Services\Inotification");
  }
  
  public function handle($event)
  {
    try {
      
      $data = $event->order;
      if (isset($data['order_id']) && isset($data['status'])) {
        $order = Order::where('id', $data['order_id']);
        $order->update(['status_id' => $data['status']]);
      }
      
      if (isset($data) && $data['notify']) {
        $order = $order->first();
        
        //Emails from setting form-emails
        $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
        if (empty($emailTo)) //validate if its a string separately by commas
          $emailTo = explode(',', setting('icommerce::form-emails'));
        
        //Emails from users selected in the setting usersToNotify
        $usersToNotity = json_decode(setting("icommerce::usersToNotify", null, "[]"));
        $users = User::whereIn("id", $usersToNotity)->get();
        $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
        
        //By last, gets the Email of the user in the order
        array_push($emailTo, $order->email);
        
        //send notification by email, broadcast and push -- by default only send by email
        $this->notification->to([
          "email" => $emailTo,
          "broadcast" => $users->pluck('id')->toArray(),
          "push" => $users->pluck('id')->toArray(),
        ])->push(
          [
            "title" => trans("icommerce::orders.messages.notificationOrder") . " #" . $order->id,
            "message" => trans("icommerce::orders.messages.statusChanged", ["orderId" => $order->id, "statusName" => $order->status->title]),
            "icon_class" => "fas fa-shopping-cart",
            "link" => $order->url,
            "comment" => $data['comment'],
            "content" => "icommerce::emails.order-notifications",
            "setting" => [
              "saveInDatabase" => 1 // now, the notifications with type broadcast need to be save in database to really send the notification
            ],
            "order" => $order
          ]
        );
        
      }
      
    } catch (\Exception $e) {
      \Log::error("Error | UpdateOrderStatus Event: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine());
    }
    
  }
  
}
