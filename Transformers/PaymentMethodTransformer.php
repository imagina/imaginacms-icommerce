<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class PaymentMethodTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    $calculations = isset($this->calculations) ? $this->calculations : null;
    $data = [
      "calculations" => $calculations
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
    return $data;
  }
}
