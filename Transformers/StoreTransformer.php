<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreTransformer extends JsonResource
{
  public function toArray($request)
  {

    $data = [
      'id' => $this->id,
      'name' => $this->when($this->name, $this->name),
      'address' => $this->when($this->address, $this->address),
      'shipping' => $this->when($this->shipping, $this->shipping),
      'phone' => $this->when($this->phone, $this->phone),
      'countryId' => $this->when($this->country_id , $this->country_id ),
      'provinceId' => $this->when($this->province_id , $this->province_id ),
      'cityId' => $this->when($this->city_id , $this->city_id ),
      'polygon' => $this->when($this->polygon , $this->polygon ),
      'options' => $this->when($this->options , $this->options ),
    ];
    return $data;
  }
}
