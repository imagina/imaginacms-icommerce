<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'code' => $this->when($this->code,$this->code),
      'symbolLeft' => $this->when($this->symbol_left,$this->symbol_left),
      'symbolRight' => $this->when($this->symbol_right,$this->symbol_right),
      'decimals' => $this->when(isset($this->decimals),(int)$this->decimals),
      'decimalSeparator' => $this->when(isset($this->decimal_separator),$this->decimal_separator),
      'thousandsSeparator' => $this->when(isset($this->thousands_separator),$this->thousands_separator),
      'defaultCurrency' => $this->default_currency ? '1' : '0',
      'value' => $this->when($this->value,$this->value),
      'status' =>  $this->status ? '1' : '0',
      'options' => $this->when($this->options,$this->options),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at),
      
    ];
  
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as $lang => $value) {
        $data[$lang]['name'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['name'] : '';
      
      }
    }
    return $data;
  }
}