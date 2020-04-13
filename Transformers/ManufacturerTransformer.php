<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ManufacturerTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status,
      'options' => $this->options,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
    ];
  
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data[$key]['name'] = $this->hasTranslation($key) ? $this->translate("$key")['name'] : '';
        }
      }
    }
    return $data;
  }
}