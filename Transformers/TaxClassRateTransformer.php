<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxClassRateTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'taxClassId' => (int)$this->when($this->pivot->tax_class_id, $this->pivot->tax_class_id),
      'taxRateId' => (int)$this->when($this->pivot->tax_rate_id, $this->pivot->tax_rate_id),
      'based' => $this->when($this->pivot->based, $this->pivot->based),
      'priority' => $this->when($this->pivot->priority, $this->pivot->priority),
      'createdAt' => $this->when($this->pivot->created_at, $this->pivot->created_at),
      'updatedAt' => $this->when($this->pivot->updated_at, $this->pivot->updated_at),
    ];


    return $data;
  }
}