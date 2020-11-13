<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturerTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name ?? '',
      'slug' => $this->slug ?? '',
      'url' => $this->url ?? '',
      'description' => $this->description ?? '',
      'storeId' => $this->when($this->store_id, $this->store_id),
      'sortOrder' => $this->when(isset($this->sort_order), ((int)$this->sort_order )),
      'metaTitle' => $this->meta_title ?? '',
      'metaDescription' => $this->meta_description ?? '',
      'options' => $this->when($this->options, $this->options),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'store' => new StoreTransformer($this->whenLoaded('store')),
      'products' => ProductTransformer::collection($this->whenLoaded('products')),
      'status' => $this->status ? '1' : '0',
      'mainImage' => $this->mainImage,
      'mediaFiles' => $this->mediaFiles()
    ];
  
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data[$key]['name'] = $this->hasTranslation($key) ? $this->translate("$key")['name'] : '';
          $data[$key]['slug'] = $this->hasTranslation($key) ? $this->translate("$key")['slug'] : '';
          $data[$key]['description'] = $this->hasTranslation($key) ? $this->translate("$key")['description'] : '';
          $data[$key]['metaTitle'] = $this->hasTranslation($key) ? $this->translate("$key")['meta_title'] : '';
          $data[$key]['metaDescription'] = $this->hasTranslation($key) ? $this->translate("$key")['meta_description'] : '';
        }
      }
    }
    return $data;
  }
}