<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateTaxClassRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
    
    ];
  }
  
  public function translationRules()
  {
    return [
      'name' => 'required|min:2',
      'description' => 'required|min:2'
    ];
  }
  
  public function authorize()
  {
    return true;
  }
  
  public function messages()
  {
    return [];
  }
  
  public function translationMessages()
  {
    return [
      // name
      'name.required' => trans('icommerce::common.messages.field required'),
      'name.min:2' => trans('icommerce::common.messages.min 2 characters'),
      
      // description
      'description.required' => trans('icommerce::common.messages.field required'),
      'description.min:2' => trans('icommerce::common.messages.min 2 characters'),
    ];
  }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
    
}
