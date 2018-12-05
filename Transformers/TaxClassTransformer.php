<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxClassTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $item =  [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    if(isset($this->rates))
      $item['rates'] = $this->rates;
    
    return $item;
  }
}