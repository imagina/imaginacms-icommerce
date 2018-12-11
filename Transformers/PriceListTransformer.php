<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PriceListTransformer extends Resource
{
  public function toArray($request)
  {
    $item = [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status,
      'criteria' => $this->criteria,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    if(isset($this->products))
      $item['products'] = $this->products;
    
    return $item;
  }
}