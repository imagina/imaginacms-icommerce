<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxRateTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'rate' => $this->rate,
      'type' => $this->type,
      'geozone_id' => $this->geozone_id,
      'customer' => $this->customer,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
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