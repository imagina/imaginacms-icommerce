<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Entities\OrderStatus;
use Modules\Icommerce\Transformers\OrderHistoryTransformer;
use Modules\Icommerce\Transformers\OrderItemTransformer;
use Modules\Iprofile\Transformers\UserTransformer;

class OrderTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'invoiceNro' => $this->when($this->invoice_nro,$this->invoice_nro),
      'invoicePrefix' => $this->when($this->invoice_prefix,$this->invoice_prefix),
      'total' => $this->when($this->total,$this->total),
      'statusId' => $this->when($this->status_id,$this->status_id),
      'statusName' => OrderStatus::find($this->when($this->status_id,$this->status_id))->title,
      'customer' => new UserTransformer($this->whenLoaded('customer')),
      'addedBy' => new UserTransformer($this->whenLoaded('addedBy')),
      'firstName' => $this->when($this->first_name,$this->first_name),
      'lastName' => $this->when($this->last_name,$this->last_name),
      'email' => $this->when($this->email,$this->email),
      'paymentFirstName' => $this->when($this->payment_first_name,$this->payment_first_name),
      'paymentLastName' => $this->when($this->payment_last_name,$this->payment_last_name),
      'paymentCompany' => $this->when($this->payment_company,$this->payment_company),
      'paymentAddress1' => $this->when($this->payment_address_1,$this->payment_address_1),
      'paymentAddress2' => $this->when($this->payment_address_2,$this->payment_address_2),
      'paymentCity' => $this->when($this->payment_city,$this->payment_city),
      'paymentZipCode' => $this->when($this->payment_zip_code,$this->payment_zip_code),
      'paymentCountry' => $this->when($this->payment_country,$this->payment_country),
      'paymentZone' => $this->when($this->payment_zone,$this->payment_zone),
      'paymentAddressFormat' => $this->when($this->payment_address_format,$this->payment_address_format),
      'paymentCustomField' => $this->when($this->payment_custom_field,$this->payment_custom_field),
      'paymentCode' => $this->when($this->payment_code,$this->payment_code),
      'paymentMethod' => $this->when($this->payment_method,$this->payment_method),
      'shippingFirstName' => $this->when($this->shipping_first_name,$this->shipping_first_name),
      'shippingLastName' => $this->when($this->shipping_last_name,$this->shipping_last_name),
      'shippingCompany' => $this->when($this->shipping_company,$this->shipping_company),
      'shippingAddress1' => $this->when($this->shipping_address_1,$this->shipping_address_1),
      'shippingAddress2' => $this->when($this->shipping_address_2,$this->shipping_address_2),
      'shippingCity' => $this->when($this->shipping_city,$this->shipping_city),
      'shippingZipCode' => $this->when($this->shipping_zip_code,$this->shipping_zip_code),
      'shippingCountry' => $this->when($this->shipping_country,$this->shipping_country),
      'shippingZone' => $this->when($this->shipping_zone,$this->shipping_zone),
      'shippingAddressFormat' => $this->when($this->shipping_address_format,$this->shipping_address_format),
      'shippingCustomField' => $this->when($this->shipping_custom_field,$this->shipping_custom_field),
      'shippingMethod' => $this->when($this->shipping_method,$this->shipping_method),
      'shippingCode' => $this->when($this->shipping_code,$this->shipping_code),
      'shippingAmount' => $this->when($this->shipping_amount,$this->shipping_amount),
      'storeName' => $this->when($this->store_name,$this->store_name),
      'storeAddress' => $this->when($this->store_address,$this->store_address),
      'storePhone' => $this->when($this->store_phone,$this->store_phone),
      'taxAmount' => $this->when($this->tax_amount,$this->tax_amount),
      'comment' => $this->when($this->comment,$this->comment),
      'tracking' => $this->when($this->tracking,$this->tracking),
      'currencyCode' => $this->when($this->currency_code,$this->currency_code),
      'currencyValue' => $this->when($this->currency_value,$this->currency_value),
      'ip' => $this->when($this->ip,$this->ip),
      'userAgent' => $this->when($this->user_agent,$this->user_agent),
      'key' => $this->when($this->key,$this->key),
      'options' => $this->when($this->options,$this->options),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at),
      'histories' => OrderHistoryTransformer::collection($this->orderHistory),
      'items' => OrderItemTransformer::collection($this->orderItems)
    ];
    
    // transactions
    if(isset($this->transactions) && count($this->transactions)>0)
      $item['transactions'] = TransactionTransformer::collection($this->transactions);
   
  
    return $item;
  }
}
