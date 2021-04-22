<?php

namespace Modules\Icommerce\Transformers;

use Modules\Isite\Http\Controllers\Api\ConfigsApiController;
use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'description' => $this->when($this->description, $this->description),
      'name' => $this->when($this->name, $this->name),
      'status' => $this->status ? 1 : 0,
      'mainImage' => $this->mainImage,
      'init' => $this->when(isset($this->options), $this->options->init),
      'options' => $this->when($this->options, $this->options),
      'parentName' => $this->when($this->parent_name, $this->parent_name),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'activevalue' => $this->active,
      'mediaFiles' => $this->mediaFiles()
    ];

    // Add Crud Fields from Payment Method
    if (isset($this->name) && !empty($this->name)) {
      $config = ucfirst($data['name']) . ".crud-fields.formFields";

      if (isset($this->parent_name) && !empty($this->parent_name))
        $config = ucfirst($data['parentName']) . ".crud-fields.formFields";

      $fieldsController = new ConfigsApiController();
      $data['crudFields'] = $fieldsController->validateResponseApi($fieldsController->index(new Request([
        'filter' => json_encode(['configName' => $config])
      ])));
    }


    //TODO falta que en el basequasar se haga un update de los forms de estos métodos para poder editar los options directamente y no tener que sacar estos campos a primer nivel
    switch ($this->name) {
      case 'icommercepayu':
        $data = array_merge($data, [
          'merchantId' => $this->when($this->options, $this->options->merchantId ?? null),
          'apiLogin' => $this->when($this->options, $this->options->apiLogin ?? null),
          'apiKey' => $this->when($this->options, $this->options->apiKey ?? null),
          'accountId' => $this->when($this->options, $this->options->accountId ?? null),
          'test' => $this->when($this->options, $this->options->test ?? null),
          'mode' => $this->when($this->options, $this->options->mode ?? null)
        ]);


      case 'icommercexpay':
        $data = array_merge($data, [
          'user' => $this->when($this->options, $this->options->user ?? null),
          'pass' => $this->when($this->options, $this->options->pass ?? null),
          'mode' => $this->when($this->options, $this->options->mode ?? null),
          'token' => $this->when($this->options, $this->options->token ?? null)
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
