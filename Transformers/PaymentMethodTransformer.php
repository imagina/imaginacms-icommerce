<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PaymentMethodTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'description' => $this->when($this->description,$this->description),
      'name' => $this->when($this->name,$this->name),
      'status' => $this->status == "1" ? true : false,
      //'image' => $this->when($this->options->mainimage,$this->options->mainimage),
      'init' => $this->when($this->options,$this->options->init),
      'mainImage' => $this->mainImage,
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];


    switch($this->name){
      case 'icommercepaypal':
        $data= array_merge($data, [
          'clientid' => $this->when($this->options,$this->options->clientid),
          'clientsecret' => $this->when($this->options,$this->options->clientsecret),
          'mode' => $this->when($this->options,$this->options->mode)
        ]);
    
        break;
  
      case 'icommercepayu':
        $data= array_merge($data, [
          'merchantid' => $this->when($this->options,$this->options->merchantid??null),
          'apilogin' => $this->when($this->options,$this->options->apilogin??null),
          'apikey' => $this->when($this->options,$this->options->apikey??null),
          'accountid' => $this->when($this->options,$this->options->accountid??null),
          'test' => $this->when($this->options,$this->options->test??null),
          'mode' => $this->when($this->options,$this->options->mode??null)
        ]);
  
     
  
    }
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';

      }
    }
    return $data;
  }
}