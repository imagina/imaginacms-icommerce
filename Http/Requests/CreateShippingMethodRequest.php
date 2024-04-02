<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateShippingMethodRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'name' => 'required'
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
    return [
      // Name
      'name.required' => trans('icommerce::common.messages.field required'),
    ];
  }

  public function translationMessages()
  {
    return [];
  }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}
