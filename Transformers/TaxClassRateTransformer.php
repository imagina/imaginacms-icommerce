<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxClassRateTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'taxRateId' => $this->when($this->tax_rate_id, $this->tax_rate_id),
      'based' => $this->when($this->based, $this->based),
      'priority' => (string)$this->priority ?? '0',
      'taxRate' => $this->whenLoaded('taxRate'),
      'taxClass' => $this->whenLoaded('taxClass'),
    ];


    return $data;
  }
}
