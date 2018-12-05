<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OptionTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $item = [
      'id' => $this->id,
      'type' => $this->type,
      'sort_order' => $this->sort_order,
      'description' => $this->description,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    if(isset($this->optionValues))
      $item["optionValues"] = $this->optionValues;
    
    return $item;
  }
}