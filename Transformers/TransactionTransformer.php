<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TransactionTransformer extends Resource
{
  public function toArray($request)
  {

    /*datos*/
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'external_code' => $this->when($this->external_code,$this->external_code),
      'order_id' => $this->when($this->order_id,$this->order_id),
      'payment_method_id' => $this->when($this->payment_method_id,$this->payment_method_id),
      'payment_method_title' => $this->when($this->paymentMethod->title,$this->paymentMethod->title),
      'amount' => $this->when($this->amount,$this->amount),
      'status' => $this->when($this->status,$this->status),
      'status_title' => $this->when($this->orderStatus->title,$this->orderStatus->title),
      'external_status' => $this->when($this->external_status,$this->external_status),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at)
    ];

    /*
    if(isset($this->paymentMethod))
      $data["payment_method"] = new PaymentMethodTransformer($this->paymentMethod);
    */
   

    return $data;

  }
}