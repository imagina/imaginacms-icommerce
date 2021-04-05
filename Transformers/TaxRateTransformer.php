<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxRateTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'rate' => $this->rate,
      'type' => $this->type,
      'geozoneId' => $this->geozone_id,
      //'customer' => new UserTransformer($this->customer),
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
    ];

    // Geozone
    if(is_module_enabled('Ilocations'))
      $data['geozone'] = new \Modules\Ilocations\Transformers\GeozoneTransformer($this->whenLoaded('geozone'));


    // TRANSLATIONS
    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){

      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data[$key]['name'] = $this->hasTranslation($key) ? $this->translate("$key")['name'] : '';
        }
      }
    }

    return $data;
  }
}
