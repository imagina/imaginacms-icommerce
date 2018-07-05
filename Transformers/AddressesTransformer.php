<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddressesTransformer extends Resource
{
  public function toArray($request)
  {
    $address = $this->firstname.' '.$this->lastname.', '.$this->address_1.', '.$this->city.', '.$this->zone.', '.$this->country;
    
    return $address;
  }
}
