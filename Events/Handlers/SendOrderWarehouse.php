<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\User\Entities\Sentinel\User;
use Modules\Notification\Services\Notification;

class SendOrderWarehouse
{

  /**
   * @var Mailer
   */
  private $mail;
  private $setting;
  private $notification;
  public $notificationService;

  public $log = "Icommerce::Event|Handlers|SendOrderWarehouse|";
  private $warehouseRepository;

  /**
   * Construct Base
   */
  public function __construct(Mailer $mail, Notification $notification)
  {
    $this->mail = $mail;
    $this->setting = app('Modules\Setting\Contracts\Setting');
    $this->notification = $notification;
    $this->notificationService = app("Modules\Notification\Services\Inotification");
    $this->warehouseRepository = app('Modules\Icommerce\Repositories\WarehouseRepository');

  }

  /**
   * Handler
   */
  public function handle($event)
  { 

    \Log::info($this->log."");

    try {

      $order = $event->order;

      if(!is_null($order->warehouse_id)){

        //Get All Data to warehouse
        $warehouse = $this->warehouseRepository->getItem($order->warehouse_id);
        \Log::info($this->log." ".$warehouse->title);

        //Get Notify Infor
        $usersToNotify = $warehouse->users_to_notify ?? null; //Only IDS
        $emailTo = $warehouse->emails_to_notify ?? null;

        //$emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));

        if(!empty($usersToNotify) && !empty($emailTo)){

          //Subject Base
          $subject = $order->warehouse_title . " | ".trans('icommerce::orders.messages.purchase order') . " #" . $order->id . ": " . $order->status->title;

          //Title
          $title = $order->warehouse_title . " | ".trans("icommerce::orders.title.confirmation_single_order_title");

          //send notification by email, broadcast and push
          $this->notificationService->to([
            "email" => $emailTo,
            "broadcast" =>$usersToNotify,
            "push" => $usersToNotify,
          ])->push([
              "title" => $title,
              "message" => $subject,
              "icon_class" => "fas fa-shopping-cart",
              "link" => $order->url,
              "content" => "icommerce::emails.order",
              "view" => "icommerce::emails.Order",
              "setting" => [
                "saveInDatabase" => 1
              ],
              "order" => $order
          ]);

        }else{
          \Log::info($this->log." UsersToNotify and EmailToNotify are EMPTY ");
        }

      }
      

    } catch (\Exception $e) {
      \Log::error($this->log.'Message: ' . $e->getMessage() . ' | FILE: ' . $e->getFile() . ' | LINE: ' . $e->getLine());
    }

  }

}