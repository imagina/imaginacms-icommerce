<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePaymentMethodRequest extends BaseFormRequest
{
  public function rules()
  {
    return [];
  }

  public function translationRules()
  {
    return [
      'title' => 'required|min:3',
      'description' => 'required|min:3'
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

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}
