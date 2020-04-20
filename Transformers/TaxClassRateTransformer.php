<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxClassRateTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'taxClassId' => $this->when($this->tax_class_id, $this->tax_class_id),
      'taxRateId' => $this->when($this->tax_rate_id, $this->tax_rate_id),
      'based' => $this->when($this->based, $this->based),
      'priority' => $this->when($this->priority, $this->priority),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];


    return $data;
  }
}