<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TagTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $data =  [
      'id' => $this->id,
      'title' => $this->title,
      'slug' => $this->slug,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    // TRANSLATIONS
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['title'] = $this->translate("$key")['title'];
          $data['translates'][$key]['slug'] = $this->translate("$key")['slug'];
        }
      }
    }
    return $data;
  }
}