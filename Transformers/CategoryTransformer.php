<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CategoryTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title ?? '',
            'slug' => $this->slug ?? '',
            'description' => $this->description ?? '',
            'parentId' => (int)$this->parent_id,
            'storeId' => $this->when($this->store_id, $this->store_id),
            'showMenu' => $this->when(isset($this->show_menu), ((int)$this->show_menu )),
            'featured' => $this->when(isset($this->featured), ((int)$this->featured )),
            'metaTitle' => $this->meta_title ?? '',
            'metaDescription' => $this->meta_description ?? '',
            'options' => $this->when($this->options, $this->options),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'parent' => new CategoryTransformer ($this->whenLoaded('parent')),
            'childrens' => CategoryTransformer::collection($this->whenLoaded('children')),
            'store' => new StoreTransformer($this->whenLoaded('store')),
            'products' => ProductTransformer::collection($this->whenLoaded('products')),
            'mainImage' => $this->mainImage,
            'files' => $this->transformerFiles()
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
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
