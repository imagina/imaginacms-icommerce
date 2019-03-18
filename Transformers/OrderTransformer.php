<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Transformers\OrderHistoryTransformer;
use Modules\Icommerce\Transformers\OrderItemTransformer;

class OrderTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'invoice_nro' => $this->when($this->invoice_nro,$this->invoice_nro),
      'invoice_prefix' => $this->when($this->invoice_prefix,$this->invoice_prefix),
      'total' => $this->when($this->total,$this->total),
      'status_id' => $this->when($this->status_id,$this->status_id),
      'status' => $this->when($this->status,$this->status),
      'added_by_id' => $this->when($this->added_by_id,$this->added_by_id),
      'customer_id' => $this->when($this->customer_id,$this->customer_id),
      'first_name' => $this->when($this->first_name,$this->first_name),
      'last_name' => $this->when($this->last_name,$this->last_name),
      'email' => $this->when($this->email,$this->email),
      'telephone' => $this->when($this->telephone,$this->telephone),
      'payment_first_name' => $this->when($this->payment_first_name,$this->payment_first_name),
      'payment_last_name' => $this->when($this->payment_last_name,$this->payment_last_name),
      'payment_company' => $this->when($this->payment_company,$this->payment_company),
      'payment_address_1' => $this->when($this->payment_address_1,$this->payment_address_1),
      'payment_address_2' => $this->when($this->payment_address_2,$this->payment_address_2),
      'payment_city' => $this->when($this->payment_city,$this->payment_city),
      'payment_zip_code' => $this->when($this->payment_zip_code,$this->payment_zip_code),
      'payment_country' => $this->when($this->payment_country,$this->payment_country),
      'payment_zone' => $this->when($this->payment_zone,$this->payment_zone),
      'payment_address_format' => $this->when($this->payment_address_format,$this->payment_address_format),
      'payment_custom_field' => $this->when($this->payment_custom_field,$this->payment_custom_field),
      'payment_code' => $this->when($this->payment_code,$this->payment_code),
      'payment_name' => $this->when($this->payment_name,$this->payment_name),
      'shipping_first_name' => $this->when($this->shipping_first_name,$this->shipping_first_name),
      'shipping_last_name' => $this->when($this->shipping_last_name,$this->shipping_last_name),
      'shipping_company' => $this->when($this->shipping_company,$this->shipping_company),
      'shipping_address_1' => $this->when($this->shipping_address_1,$this->shipping_address_1),
      'shipping_address_2' => $this->when($this->shipping_address_2,$this->shipping_address_2),
      'shipping_city' => $this->when($this->shipping_city,$this->shipping_city),
      'shipping_zip_code' => $this->when($this->shipping_zip_code,$this->shipping_zip_code),
      'shipping_country' => $this->when($this->shipping_country,$this->shipping_country),
      'shipping_zone' => $this->when($this->shipping_zone,$this->shipping_zone),
      'shipping_address_format' => $this->when($this->shipping_address_format,$this->shipping_address_format),
      'shipping_custom_field' => $this->when($this->shipping_custom_field,$this->shipping_custom_field),
      'shipping_method' => $this->when($this->shipping_method,$this->shipping_method),
      'shipping_code' => $this->when($this->shipping_code,$this->shipping_code),
      'shipping_amount' => $this->when($this->shipping_amount,$this->shipping_amount),
      'store_id' => $this->when($this->store_id,$this->store_id),
      'store_name' => $this->when($this->store_name,$this->store_name),
      'store_address' => $this->when($this->store_address,$this->store_address),
      'store_phone' => $this->when($this->store_phone,$this->store_phone),
      'tax_amount' => $this->when($this->tax_amount,$this->tax_amount),
      'comment' => $this->when($this->comment,$this->comment),
      'tracking' => $this->when($this->tracking,$this->tracking),
      'currency_id' => $this->when($this->currency_id,$this->currency_id),
      'currency_code' => $this->when($this->currency_code,$this->currency_code),
      'currency_value' => $this->when($this->currency_value,$this->currency_value),
      'ip' => $this->when($this->ip,$this->ip),
      'user_agent' => $this->when($this->user_agent,$this->user_agent),
      'key' => $this->when($this->key,$this->key),
      'options' => $this->when($this->options,$this->options),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at),
      'histories' => OrderHistoryTransformer::collection($this->orderHistory),
      'items' => OrderItemTransformer::collection($this->orderItems)
    ];
    
    // transactions
    if(isset($this->transactions) && count($this->transactions)>0)
      $item['transactions'] = TransactionTransformer::collection($this->transactions);
   
  
    return $item;
  }
}
