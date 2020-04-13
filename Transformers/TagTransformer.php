<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TagTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'slug' => $this->when($this->slug,$this->slug),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    // TRANSLATIONS
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        if ($this->hasTranslation($lang)) {
          $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
          $data[$lang]['slug'] = $this->hasTranslation($lang) ? $this->translate("$lang")['slug'] : '';

        }
      }
    }
    return $data;
  }
}