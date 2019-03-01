<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class MapAreaTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'polygon' => $this->when($this->id, $this->id),
            'store' => StoreTransformer::collection($this->whenLoaded('store')),
        ];
        return $data;
    }
}
