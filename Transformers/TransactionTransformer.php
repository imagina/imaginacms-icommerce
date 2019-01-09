<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TransactionTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $data =  [
      'id' => $this->id,
      'external_code' => $this->external_code,
      'order_id' => $this->order_id,
      'payment_method_id' => $this->payment_method_id,
      'amount' => $this->amount,
      'status' => $this->status,
      'external_status' => $this->external_status,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    
    return $data;
  }
}