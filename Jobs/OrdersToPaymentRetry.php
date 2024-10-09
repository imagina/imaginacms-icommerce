<?php

namespace Modules\Icommerce\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;


class OrdersToPaymentRetry implements ShouldQueue
{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   
    /**
     * vars
     */
    private $log;

    /**
     * 
     */
    public function __construct()
    {
        $this->log = 'Icommerce: Jobs|OrdersToPaymentRetry|';
    }

    /**
     * Handle | Init
     */
    public function handle()
    {
        \DB::beginTransaction();
        try{

            /**
             * Ordenes que no estan procesadas
             * Intentos de Pago sea mayor a 0
             */
            $orders = Order::where("status_id","!=",13)
            ->where("payment_attemps",">",0)
            ->get();

            //Info msj
            \Log::info($this->log."Orders: ".count($orders));

            //Exist Orders to retry
            if(count($orders) > 0) 
            {   
                 
                foreach ($orders as $order) 
                {
                    //Update Status to Pending
                    $order->status_id = 1; 
                    $order->payment_attemps = $order->payment_attemps - 1;
                    $order->save();
                    \Log::info($this->log."Change to Pending OrderId: ".$order->id);

                    //Create Comment
                    $orderStatusHistory = OrderStatusHistory::create([
                        "order_id" => $order->id,
                        "notify" => 1,
                        "comment" => trans("icommerce::orders.messages.order updated by attempt",['paymentMethod'=>$order->payment_method]),
                        "status" => $order->status_id
                    ]);
                    event(new OrderStatusHistoryWasCreated($orderStatusHistory));

                    //Process Payment
                    $payment = app("Modules\Icommerce\Services\PaymentMethodService")->checkPaymentMethod($order);
                }

            }


            //FINAL COMMIT
            \DB::commit();

        } catch (\Exception $e) {
            
            \DB::rollback();

            \Log::info($this->log."ERROR");
            \Log::Error($e);
        }
       

    }
  
   
}