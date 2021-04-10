<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxClassRateTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'taxRateId' => (int)$this->when($this->pivot->tax_rate_id, $this->pivot->tax_rate_id),
      'based' => $this->when($this->pivot->based, $this->pivot->based),
      'priority' => (string)$this->pivot->priority ?? '0',
      'createdAt' => $this->when($this->pivot->created_at, $this->pivot->created_at),
      'updatedAt' => $this->when($this->pivot->updated_at, $this->pivot->updated_at),
    ];


    return $data;
  }
}
