<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CouponTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'code' => $this->code,
      'type' => $this->type,
      'discount' => $this->discount,
      'logged' => $this->logged,
      'shipping' => $this->shipping,
      'total' => $this->total,
      'date_start' => $this->date_start,
      'date_end' => $this->date_end,
      'uses_total' => $this->uses_total,
      'status' => $this->status,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      
    ];
  
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