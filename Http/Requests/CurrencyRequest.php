<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CurrencyRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'code' => 'required|min:2',
      'value' => 'required',
      'name' => 'required|min:2',
    ];
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
    return [
      // code
      'code.required' => trans('icommerce::common.messages.field required'),
      'code.min:2' => trans('icommerce::common.messages.min 2 characters'),
      
      // value
      'value.required' => trans('icommerce::common.messages.field required'),
      
    ];
  }
  
  public function translationMessages()
  {
    return [
      // title
      'title.required' => trans('icommerce::common.messages.field required'),
      'title.min:2' => trans('icommerce::common.messages.min 2 characters'),
    
    ];
  }
}
