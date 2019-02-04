<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionValueTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'product_option_id' => $this->product_option_id,
      'product_id' => $this->product_id,
      'option_id' => $this->option_id,
      'option_value_id' => $this->option_value_id,
      'option_value' => $this->optionValue->description,
      'parent_option_value_id' => $this->parent_option_value_id,
      'quantity' => $this->quantity,
      'substract' => $this->substract,
      'price' => $this->price,
      'weight' => $this->weight,
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
          $data['translates'][$key]['name'] = $this->translate("$key")['name'];
          $data['translates'][$key]['description'] = $this->translate("$key")['description'];
          $data['translates'][$key]['summary'] = $this->translate("$key")['summary'];
        }
      }
    }

    return $data;
  }
}
