<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateLengthClassRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'value' => 'required'
    ];
  }
  
  public function translationRules()
  {
    return [
      'title' => 'required',
      'unit' => 'required'
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
    return [];
  }
  
  public function getValidator()
  {
    return $this->getValidatorInstance();
  }
  
}
