<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionValueTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'description' => $this->description,
            'optionId' => $this->when($this->option_id, $this->option_id),
            'sortOrder' => $this->when($this->sort_order, $this->sort_order),
            'options' => $this->options,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'option' => new OptionTransformer($this->whenLoaded('option')),
            'mainImage' => $this->mainImage,
            'mediaFiles' => $this->mediaFiles(),
        ];

        $filter = json_decode($request->filter);
        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();
            foreach ($languages as  $lang => $value) {
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['description'] : '';
            }
        }

        //Response
        return $data;
    }
}
