<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxClassTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        // Rates
        if (isset($this->rates)) {
            $data['rates'] = TaxClassRateTransformer::collection($this->rates);
        }

        // TRANSLATIONS
        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as  $key => $value) {
                if ($this->hasTranslation($key)) {
                    $data[$key]['name'] = $this->hasTranslation($key) ? $this->translate("$key")['name'] : '';
                    $data[$key]['description'] = $this->hasTranslation($key) ? $this->translate("$key")['description'] : '';
                }
            }
        }

        return $data;
    }
}
