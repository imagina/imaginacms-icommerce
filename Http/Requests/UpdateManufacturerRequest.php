<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateManufacturerRequest extends BaseFormRequest
{
  public function rules()
  {
    return [];
  }
  
  public function translationRules()
  {
    return [
      'name' => 'required|min:2',
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
      // title
      'name.required' => trans('icommerce::common.messages.field required'),
      'name.min:2' => trans('icommerce::common.messages.min 2 characters'),
    
    ];
  }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}
