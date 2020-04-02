<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class StoreTransformer extends Resource
{
    public function toArray($request)
    {

        $data = [
            'id' => $this->id,
            'name' => $this->when($this->name, $this->name),
            'address' => $this->when($this->address, $this->address),
            'shipping' => $this->when($this->shipping, $this->shipping),
            'phone' => $this->when($this->phone, $this->phone),
           
        ];
        
        return $data;
    }
}
