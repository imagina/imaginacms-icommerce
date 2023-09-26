<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxClassRateTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'taxRateId' => $this->when($this->tax_rate_id, $this->tax_rate_id),
            'based' => $this->when($this->based, $this->based),
            'priority' => (string) $this->priority ?? '0',
            'taxRate' => new TaxRateTransformer($this->whenLoaded('taxRate')),
            'taxClass' => new TaxClassTransformer($this->whenLoaded('taxClass')),
        ];

        return $data;
    }
}
