<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icurrency\Support\Facades\Currency;

class CartTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'ip' => $this->when($this->ip, $this->ip),
            'sessionId' => $this->when($this->session_id, $this->session_id),
            'userId' => $this->when($this->user_id, $this->user_id),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'total' => $this->when($this->total, Currency::convert($this->total)),
            'quantity' => $this->when($this->quantity, $this->quantity),
            'storeId' => $this->store_id,
            'products' => CartProductTransformer::collection($this->whenLoaded('products')),
        ];

        return $data;
    }
}
