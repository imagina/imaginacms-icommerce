<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CurrencyTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'code' => $this->when($this->code,$this->code),
      'symbol_left' => $this->when($this->symbol_left,$this->symbol_left),
      'symbol_right' => $this->when($this->symbol_right,$this->symbol_right),
      'decimal_place' => $this->when($this->decimal_place,$this->decimal_place),
      'value' => $this->when($this->value,$this->value),
      'status' => $this->when($this->status,$this->status),
      'options' => $this->when($this->options,$this->options),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at),
      
    ];
  
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){
    
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['title'] = $this->translate("$key")['title'];
        }
      }
    }
    return $data;
  }
}