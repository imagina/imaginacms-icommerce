<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CategoryTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'title' => $this->title,
      'url' => $this->url,
      'description' => $this->description,
      'slug' => $this->slug,
      'meta_title' => $this->meta_title,
      'meta_description' => $this->meta_description,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    $filter = json_decode($request->filter);
    
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['title'] = $this->translate("$key")['title'];
          $data['translates'][$key]['description'] = $this->translate("$key")['description'];
          $data['translates'][$key]['slug'] = $this->translate("$key")['slug'];
          $data['translates'][$key]['meta_title'] = $this->translate("$key")['meta_title'];
          $data['translates'][$key]['meta_description'] = $this->translate("$key")['title'];
        }
      }
    }
    return $data;
  }
}