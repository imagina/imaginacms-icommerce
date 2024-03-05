<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Isite\Http\Controllers\Api\ConfigsApiController;

class ShippingMethodTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    $data = [];
  
    // Add Crud Fields from Payment Method
    if (isset($this->name) && !empty($this->name)) {
      $config = ucfirst($this->name) . ".crud-fields.formFields";
    
      if (isset($this->parent_name) && !empty($this->parent_name))
        $config = ucfirst($this->parent_name) . ".crud-fields.formFields";
    
      $fieldsController = new ConfigsApiController();
      $data['crudFields'] = $fieldsController->validateResponseApi($fieldsController->index(new Request([
        'filter' => json_encode(['configName' => $config])
      ])));
    }
  
  
    switch ($this->name) {
    
    
      case 'icommerceflatrate':
        $data = array_merge($data, [
          'cost' => $this->when($this->options, $this->options->cost)
        ]);
        break;
      case 'icommercefreeshipping':
      
        $data = array_merge($data, [
          'minimum' => $this->when($this->options, $this->options->minimum)
        ]);
      
        break;
    
    }
  
    // It's not a relation
    if (isset($this->calculations)) {
      $data['calculations'] = $this->calculations;
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
