<?php

namespace Modules\Icommerce\Events\Handlers;


class CheckExpiredStatus
{

  private $orderRepository;
  private $log = "Icommerce::Event|Handlers|CheckExpiredStatus|";

  public function __construct()
  {
    $this->orderRepository = app('Modules\Icommerce\Repositories\OrderRepository');
  }

  /**
   * Handler
   */
  public function handle($event)
  {
    try {

      $data = $event->order;

      $user =  \Auth::user();

      //Get status
      $status = $data->status_id ?? $data->status;

      //Validation to update attribute
      if($status==14 && $user){
        $this->orderRepository->updateBy($data['order_id'],['expired_by_id' => $user->id]);
      }

    } catch (\Exception $e) {
      \Log::error($this->log." " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine());
    }

  }



}
