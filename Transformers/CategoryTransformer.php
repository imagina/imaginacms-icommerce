<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Isite\Transformers\RevisionTransformer;

class CategoryTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'externalId' => $this->when($this->external_id, $this->external_id),
      'title' => $this->title ?? '',
      'h1Title' => $this->h1_title ?? '',
      'slug' => $this->slug ?? '',
      'url' => $this->url ?? '',
      'newUrl' => $this->new_url ?? '',
      'description' => $this->description ?? '',
      'parentId' => (int)$this->parent_id,
      'storeId' => $this->when($this->store_id, $this->store_id),
      'organizationId' => $this->when($this->organization_id, $this->organization_id),
      'showMenu' => $this->when(isset($this->show_menu), ((boolean)$this->show_menu)),
      'featured' => $this->when(isset($this->featured), ((boolean)$this->featured)),
      'sortOrder' => !$this->sort_order ? "0" : (string)$this->sort_order,
      'metaTitle' => $this->meta_title ?? '',
      'metaDescription' => $this->meta_description ?? '',
      'options' => $this->options,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'parent' => new CategoryTransformer ($this->whenLoaded('parent')),
      'children' => CategoryTransformer::collection($this->whenLoaded('children')),
      'store' => new StoreTransformer($this->whenLoaded('store')),
      'products' => ProductTransformer::collection($this->whenLoaded('products')),
      'ownProducts' => ProductTransformer::collection($this->whenLoaded('ownProducts')),
      //'mainImage' => $this->mainImage,
      'status' => $this->status ? '1' : '0',
      'mediaFiles' => $this->mediaFiles(),
      'layoutId' => $this->layout_id,
      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
    ];
    
    $filter = json_decode($request->filter);
    
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang][ 'h1Title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['h1_title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
        $data[$lang]['slug'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['slug'] : '';
        $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_title'] : '';
        $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_description'] : '';
      }
    }
    return $data;
  }
}
