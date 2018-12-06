<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'invoice_nro' => $this->invoice_nro,
      'invoice_prefix' => $this->invoice_prefix,
      'total' => $this->total,
      'status_id' => $this->status_id,
      'status' => $this->status,
      'added_by_id' => $this->added_by_id,
      'customer_id' => $this->customer_id,
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'email' => $this->email,
      'telephone' => $this->telephone,
      'payment_first_name' => $this->payment_first_name,
      'payment_last_name' => $this->payment_last_name,
      'payment_company' => $this->payment_company,
      'payment_address_1' => $this->payment_address_1,
      'payment_address_2' => $this->payment_address_2,
      'payment_city' => $this->payment_city,
      'payment_zip_code' => $this->payment_zip_code,
      'payment_country' => $this->payment_country,
      'payment_zone' => $this->payment_zone,
      'payment_address_format' => $this->payment_address_format,
      'payment_custom_field' => $this->payment_custom_field,
      'payment_code' => $this->payment_code,
      'shipping_first_name' => $this->shipping_first_name,
      'shipping_last_name' => $this->shipping_last_name,
      'shipping_company' => $this->shipping_company,
      'shipping_address_1' => $this->shipping_address_1,
      'shipping_address_2' => $this->shipping_address_2,
      'shipping_city' => $this->shipping_city,
      'shipping_zip_code' => $this->shipping_zip_code,
      'shipping_country' => $this->shipping_country,
      'shipping_zone' => $this->shipping_zone,
      'shipping_address_format' => $this->shipping_address_format,
      'shipping_custom_field' => $this->shipping_custom_field,
      'shipping_method' => $this->shipping_method,
      'shipping_code' => $this->shipping_code,
      'shipping_amount' => $this->shipping_amount,
      'tax_amount' => $this->tax_amount,
      'comment' => $this->comment,
      'tracking' => $this->tracking,
      'currency_id' => $this->currency_id,
      'currency_code' => $this->currency_code,
      'currency_value' => $this->currency_value,
      'ip' => $this->ip,
      'user_agent' => $this->user_agent,
      'key' => $this->key,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    // Currency
    if(isset($this->currency))
      $item['currency'] = $this->currency;
    
    // added By
    if(isset($this->addedBy))
      $item['addedBy'] = $this->addedBy;
    
    // products
    if(isset($this->products))
      $item['products'] = $this->products;
    
    // order Products
    if(isset($this->orderProducts))
      $item['orderProducts'] = $this->orderProducts;
    
    // coupons
    if(isset($this->coupons))
      $item['coupons'] = $this->coupons;
    
    // order History
    if(isset($this->orderHistory))
      $item['orderHistory'] = $this->orderHistory;
  
    // order Option
    if(isset($this->orderOption))
      $item['orderOption'] = $this->orderOption;
  
    // transactions
    if(isset($this->transactions))
      $item['transactions'] = $this->transactions;
  
    return $item;
  }
}