<?php

namespace Modules\Icommerce\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Icommerce\Entities\Subscription;
use Modules\Icommerce\Entities\SubscriptionStatus;
use Modules\Icommerce\Entities\Cart;

use Modules\Icommerce\Entities\Order;

class CheckSubscriptions implements ShouldQueue
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
        $this->log = 'Icommerce: Jobs|CheckSubscriptions|';
    }

    /**
     * Handle | Init
     */
    public function handle()
    {
        \DB::beginTransaction();
        try{

            //Get Dates
            $nowDate = date('Y-m-d');
          
            //Get Subscriptions to Payment (First Time Order)
            /**
             * Solo subscripciones ACTIVAS
             * DATE_ADD = Se obtiene la fecha en que se debe comenzar a cobrar
             * DATEDIFF = Se compara esa fecha con la fecha actual, si es igual o menor es que ya se debe comenzar a cobrar
             */
            $subscriptions = Subscription::select(
                '*'
            )->where("status_id", SubscriptionStatus::ACTIVE)
            ->whereRaw(\DB::raw("DATEDIFF(DATE_ADD(due_date,INTERVAL -days_before_due DAY),'$nowDate')<=0"))
            ->get();

            //Info msj
            \Log::info($this->log."Ended: ".count($subscriptions));

            //Exist Subscriptions to check
            if(count($subscriptions) > 0) 
            {   
                
                //Each subscription expired
                foreach ($subscriptions as $subscription) 
                {
                    //Update Status Subscription
                    $subscription->status_id = SubscriptionStatus::PAYMENT_PENDING;
                    $subscription->save();
                    \Log::info($this->log."Pending Payment SubscriptionId: ".$subscription->id);

                    //History
                    $subscription->subscriptionStatusHistory()->create([
                        'status_id' => $subscription->status_id,
                        'notify' => 0
                    ]);
                    
                    //Process Order
                    $order = $this->createOrder($subscription);

                    //Process Payment
                    $payment = app("Modules\Icommerce\Services\PaymentMethodService")->checkPaymentMethod($order);


                }

                \Log::info($this->log."Subscriptions|END");
            }

            //FINAL COMMIT
            \DB::commit();

        } catch (\Exception $e) {
            
            \DB::rollback();

            \Log::info($this->log."ERROR");
            \Log::Error($e);

            dd($e);
        }
       

    }
    /**
     * Create Cart To order
     */
    public function createCart($order)
    {
        \Log::info($this->log."Create Cart");  

        //Get Products 
        $products = [];

        /**
         * Otra opcion:
         * Poner el carrito en status activo, y cambiar el delete
         */

        //Old Cart from order
        $cart =  Cart::find($order->cart_id);
        //Esto no pasa todo el tiempo, el carrito "nuevo" no queda eliminado
        if(is_null($cart))
            $cart = Cart::withTrashed()->find($order->cart_id);

        \Log::info($this->log."Create Cart|Old Cart Id: ".$cart->id); 
        
        //Get Products and productOptionValues from Old Cart
        foreach ($cart->products as $key => $carProduct) 
        {    
            $product = [
                "id" => $carProduct->product_id,
                "quantity" => $carProduct->quantity,
                "productOptionValues" => $carProduct->productOptionValues
            ];
            array_push($products,$product);
        }

        \Log::info($this->log."Create Cart|Ready to Create"); 
        
        //Create New Cart
        $cart = app("Modules\Icommerce\Services\CartService")->create(['products'=>$products]);

        //Add User Order from Old Order
        $cart->user_id = $order->customer_id;
        $cart->save();

        return $cart;
    }
    /**
     * Create Final Order
     */
    public function createOrder($subscription)
    {
        \Log::info($this->log."Create Order");

        $order = $subscription->order;

        //Create Cart
        $cart = $this->createCart($order);

        //Fix Data
        $data = [
            'customer' => $order->customer,
            'addedById' => $order->added_by_id,
            'cart' => $cart,
            'shipping_first_name' => $order->shipping_first_name,
            'shipping_last_name' => $order->shipping_last_name,
            'shipping_address_1' => $order->shipping_address_1,
            'shipping_address_2' => $order->shipping_address_2,
            'shipping_city' => $order->shipping_city,
            'shipping_zip_code' => $order->shipping_zip_code,
            'shipping_country_code' => $order->shipping_country_code,
            'shipping_zone' => $order->shipping_zone,
            'shipping_telephone' => $order->shipping_telephone,
            'payment_first_name' => $order->payment_first_name,
            'payment_last_name' => $order->payment_last_name,
            'payment_address_1' => $order->payment_address_1,
            'payment_address_2' => $order->payment_address_2,
            'payment_city'      => $order->payment_city,
            'payment_zip_code' => $order->payment_zip_code,
            'payment_country' => $order->payment_country,
            'payment_zone' => $order->payment_zone,
            'payment_telephone' => $order->payment_telephone,
            'shipping_method' => $order->shipping_method,
            'shipping_code' => $order->shipping_code,
            'shipping_amount' => $order->shipping_amount,
            'payment_code' => $order->payment_code,
            'payment_method' => $order->payment_method,
            'currency_id' => $order->currency_id,
            'currency_code' => $order->currency_code,
            'currency_value' => $order->currency_value,
            'guest_purchase' => $order->guest_purchase,
            'options' => (array)$order->options,
            'subscription_id' => $subscription->id,
            'subscription_type' => get_class($subscription)
        ];

        //Check Payment Method Attemps
        $paymentMethod = $order->paymentMethod;
        if(!is_null($paymentMethod)){
            if(isset($paymentMethod->options) && isset($paymentMethod->options->paymentAttemps)){

                $paymentAttemps = $paymentMethod->options->paymentAttemps;

                //Discount Attemp because a charge will be made 
                if($paymentAttemps>0)
                    $data['payment_attemps'] = $paymentAttemps - 1;
            }
        }
       
        //Create
        $response = app("Modules\Icommerce\Services\OrderService")->create($data);
        
        \Log::info($this->log."New Order Id: ".$response['order']->id);
        \Log::info($this->log."Create Order | END");

        return $response['order'];

    }

    /**
     * Process to Payment | OJO ESTO ELIMINARLO QUE SE PASO A UN SERVICIO
     */
    public function checkPaymentMethod($order)
    {

        \Log::info($this->log."Check Payment Method to OrderId: ".$order->id);

        $paymenMethod =  $order->paymentMethod;

        //Validation Exist
        if(!is_null($paymenMethod))
        {
            \Log::info($this->log."Payment Method: ".$paymenMethod->name);

            $nameSpace = $paymenMethod->name;
            //Es un metodo Hijo
            if(!is_null($paymenMethod->parent_name)) $nameSpace = $paymenMethod->parent_name;

            //Validation Class
            $baseClass = "Modules\\".ucfirst($nameSpace)."\Services\RecurrenceService";
            if(class_exists($baseClass)){

                $service = app($baseClass);
                //Validation Method
                if(method_exists($service, "init")){
                    //Init Payment Process
                    $result = $service->init($order,$paymenMethod);
                    
                }
            }else{
                \Log::error($this->log."Payment Method | Recurrence Service does not exist ");
            }
            
        }else{
            \Log::error($this->log."ERROR|Payment Method Id not found| PaymentMethodId: ".$order->payment_code);
        }

    }

}