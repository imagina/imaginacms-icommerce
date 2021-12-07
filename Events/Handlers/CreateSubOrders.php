<?php

namespace Modules\Icommerce\Events\Handlers;


class CreateSubOrders
{
  
  
  public function handle($event = null)
  {
    
    
    $order = $event->order;
    
    if (!isset($order->parent_id) || empty($order->parent_id)) {
      $organizations = $order->orderItems->pluck("organization_id")->toArray();
      
      // recorriendo cada org id en los items de la orden
      foreach ($organizations as $organizationId) {
        
        $organizationOrderItems = $order->orderItems->where("organization_id", $organizationId);
        
        $coupon = $order->coupons->first();
        $data = [
          'parentId' => $order->id,
          'customerId' => $order->customer_id,
          'addedById' => $order->added_by_id,
          'cartId' => $order->cart_id,
          'options' => json_decode(json_encode($order->options), true),
          "shipping_first_name" => $order->shipping_first_name,
          "shipping_last_name" => $order->shipping_last_name,
          "shipping_address_1" => $order->shipping_address_1,
          "shipping_address_2" => $order->shipping_address_2,
          "shipping_city" => $order->shipping_city,
          "shipping_zip_code" => $order->shipping_zip_code,
          "shipping_country_code" => $order->shipping_country_code,
          "shipping_zone" => $order->shipping_zone,
          "shipping_telephone" => $order->shipping_telephone,
          "shipping_address_options" => $order->options->shippingAddress ?? null,
          "payment_first_name" => $order->payment_first_name,
          "payment_last_name" => $order->payment_last_name,
          "payment_address_1" => $order->payment_address_1,
          "payment_address_2" => $order->payment_address_2,
          "payment_city" => $order->payment_city,
          "payment_zip_code" => $order->payment_zip_code,
          "payment_country" => $order->payment_country,
          "payment_zone" => $order->payment_zone,
          "payment_telephone" => $order->payment_telephone,
          "billing_address_options" => $order->options->billingAddress ?? null,
          "shipping_method" => $order->shipping_method,
          "shipping_code" => $order->shipping_code,
          "shipping_amount" => $order->shipping_amount,
          "paymentCode" => $order->paymentCode,
          "paymentMethod" => $order->paymentMethod,
          "currency_id" => $order->currency_id,
          "currency_code" => $order->currency_code,
          "currency_value" => $order->currency_value,
          "organization_id" => $organizationId,
          "coupon" => $coupon
        ];
        
        // Creating Sub Order
        $subOrderCreated = app("Modules\Icommerce\Services\OrderService")->create($data);
        
        
      }
      
    }
    
    
  }
  
}