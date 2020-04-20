<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxClassRateTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'taxClassId' => $this->when($this->created_at),
      'taxRateId'=> $this->when($this->created_at),
      'based' => $this->when($this->created_at),
      'priority' => $this->when($this->created_at),
      'createdAt' => $this->when($this->created_at),
      'updatedAt' => $this->when($this->updated_at),
    ];

    return $data;
  }
}