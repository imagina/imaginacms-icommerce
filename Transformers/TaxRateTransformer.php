<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iprofile\Transformers\UserTransformer;

class TaxRateTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'rate' => $this->rate,
      'type' => $this->type,
      'geozoneId' => $this->geozone_id,
      'customer' => new UserTransformer($this->customer),
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
    ];
    
    // Geozone
    if(isset($this->geozone))
      $data['geozone'] = $this->geozone;
  
  
    // TRANSLATIONS
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['name'] = $this->translate("$key")['name'];
        }
      }
    }
    
    return $data;
  }
}