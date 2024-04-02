<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateOptionRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'type' => 'required',
    
    ];
  }
  
  public function translationRules()
  {
    return [
      'description' => 'required|min:1',
    ];
  }
  
  public function authorize()
  {
    return true;
  }
  
  public function messages()
  {
    return [
      // type
      'type.required' => trans('icommerce::common.messages.field required'),
      
      // sort_order
      'sort_order.required' => trans('icommerce::common.messages.field required'),
    
    ];
  }
  
  public function translationMessages()
  {
    return [
      // description
      'description.required' => trans('icommerce::common.messages.field required'),
      'description.min:1' => trans('icommerce::common.messages.min 1 characters'),
    ];
  }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}
