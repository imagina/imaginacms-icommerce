<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TaxClassTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    // Rates
    if(isset($this->rates))
      $data['rates'] = $this->rates;
  
  
    // TRANSLATIONS
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['name'] = $this->translate("$key")['name'];
          $data['translates'][$key]['description'] = $this->translate("$key")['description'];
        }
      }
    }
    
    return $data;
  }
}