<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistTransformer extends JsonResource
{
    public function toArray($request)
    {
        $item = [
            'id' => $this->when($this->id, $this->id),
            'user_id' => $this->when($this->user_id, $this->user_id),
            'product_id' => $this->when($this->product_id, $this->product_id),
            'product' => new ProductTransformer($this->product),
            'created_at' => $this->when($this->created_at, $this->created_at),
            'updated_at' => $this->when($this->updated_at, $this->updated_at),
        ];

        // User
        if (isset($this->user)) {
            $item['user'] = $this->user;
        }

        return $item;
    }
}
