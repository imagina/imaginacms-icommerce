<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'description' => $this->description,
      'type' => $this->when($this->type,$this->type),
      'sortOrder' => $this->when($this->sort_order,$this->sort_order),
      'options' => $this->when($this->options,$this->options),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at),
      'optionValues' => OptionValueTransformer::collection($this->whenLoaded('optionValues')),
      'dinamic' => $this->dinamic
    ];

    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as  $lang => $value){
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] : '';
      }
    }

    //Response
    return $data;
  }
}
