<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemTypeTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'title' => $this->title,
      'options' => $this->when($this->options,$this->options),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at),
    ];

    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as  $lang => $value){
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
      }
    }

    //Response
    return $data;
  }
}
