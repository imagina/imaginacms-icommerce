<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PriceListTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status,
      'criteria' => $this->criteria,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    if(isset($this->products))
      $data['products'] = $this->products;
  
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