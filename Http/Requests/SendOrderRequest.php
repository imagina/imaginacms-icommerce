<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class SendOrderRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'order_id' => 'required'
    ];
  }

  public function translationRules()
  {
    return [];
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

  public function getValidator(){
    return $this->getValidatorInstance();
  }

}