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
      'externalCode' => $this->when($this->external_code,$this->external_code),
      'orderId' => $this->when($this->order_id,$this->order_id),
      'paymentMethodId' => $this->when($this->payment_method_id,$this->payment_method_id),
      'paymentMethodTitle' => $this->when($this->paymentMethod->title,$this->paymentMethod->title),
      'amount' => $this->when($this->amount,$this->amount),
      'status' => $this->when($this->status,$this->status),
      'statusTitle' => $this->when($this->orderStatus->title,$this->orderStatus->title),
      'externalStatus' => $this->when($this->external_status,$this->external_status),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];

    /*
    if(isset($this->paymentMethod))
      $data["payment_method"] = new PaymentMethodTransformer($this->paymentMethod);
    */
   

    return $data;

  }
}