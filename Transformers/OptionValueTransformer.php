<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OptionValueTransformer extends Resource
{
  public function toArray($request)
  {
    return  [
      'id' => $this->id,
      'option_id' => $this->option_id,
      'sort_order' => $this->sort_order,
      'description' => $this->description,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}