<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CurrencyTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    return  [
      'id' => $this->id,
      'title' => $this->title,
      'code' => $this->code,
      'symbol_left' => $this->symbol_left,
      'symbol_right' => $this->symbol_right,
      'decimal_place' => $this->decimal_place,
      'value' => $this->value,
      'status' => $this->status,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      
    ];
  }
}