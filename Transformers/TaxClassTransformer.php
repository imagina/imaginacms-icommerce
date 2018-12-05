<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxClassTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    // Rates
    if(isset($this->rates))
      $item['rates'] = $this->rates;
    
    return $item;
  }
}