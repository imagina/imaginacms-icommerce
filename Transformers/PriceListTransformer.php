<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class PriceListTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status,
      'criteria' => $this->criteria,
      'value' => $this->value,
      'operationPrefix' => $this->operation_prefix,
      //'entity' => app($this->related_entity)->find($this->related_id),
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
    ];

    $this->ifRequestInclude('products') ?
      $data['products'] = ($this->products ? new ProductTransformer($this->products) : false) : false;

    $request->input('entity') ?
      $data['entity'] = $this->entity  : false;

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){

      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['name'] = $this->translate("$key")['name'];
        }
      }
    }
    return $data;
  }
}
