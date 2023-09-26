<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusTransformer extends JsonResource
{
    public function toArray($request)
    {
        $item = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'parentId' => $this->when($this->parent_id, $this->parent_id),
            'status' => $this->when($this->status, $this->status),
        ];

        return $item;
    }
}
