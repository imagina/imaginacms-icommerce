<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CategoryTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'slug' => $this->when($this->slug,$this->slug),
      'description' => $this->when($this->description,$this->description),
      'url' => $this->when($this->url,$this->url),
      'parent_id' => $this->when($this->parent_id,$this->parent_id),
      'show_menu' => $this->when($this->show_menu,$this->show_menu),
      'meta_title' => $this->when($this->meta_title,$this->meta_title),
      'meta_description' => $this->when($this->meta_description,$this->meta_description),
      'options' => $this->when($this->options,$this->options),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at),
      'parent' => new CategoryTransformer ($this->whenLoaded('parent')),
      'childrens' => CategoryTransformer::collection($this->whenLoaded('children')),
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
