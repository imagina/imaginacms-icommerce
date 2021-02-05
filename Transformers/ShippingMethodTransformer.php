<?php

namespace Modules\Icommerce\Transformers;

use Modules\Isite\Http\Controllers\Api\FieldsApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'description' => $this->when($this->description,$this->description),
      'name' => $this->when($this->name,$this->name),
      'status' => $this->status ? 1 : 0,
      'options' => $this->when($this->options,$this->options),
      'parentName' => $this->when($this->parent_name, $this->parent_name),
      'init' => $this->when($this->options,$this->options->init),
      'mainImage' => $this->mainImage,
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at),
      'mediaFiles' => $this->mediaFiles()
    ];

  

    // Add Crud Fields from Payment Method
    if (isset($this->name) && !empty($this->name)) {
      $config = "crud-fields." . ucfirst($data['name']) . ".formFields";

        if (isset($this->parent_name) && !empty($this->parent_name))
          $config = "crud-fields." . ucfirst($data['parentName']) . ".formFields";

        $fieldsController = new FieldsApiController();
        $data['crudFields'] = $fieldsController->validateResponseApi($fieldsController->index(new Request([
            'filter' => json_encode(['configFieldName' => $config])
        ])));
    }


    switch($this->name){


      case 'icommerceflatrate':
        $data= array_merge($data, [
          'cost' => $this->when($this->options,$this->options->cost)
        ]);
        break;
      case 'icommercefreeshipping':

        $data= array_merge($data, [
          'minimum' => $this->when($this->options,$this->options->minimum)
        ]);

        break;

    }

    // It's not a relation
    if (isset($this->calculations)) {
      $data['calculations']= $this->calculations;
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
