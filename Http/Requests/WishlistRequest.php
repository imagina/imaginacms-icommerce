<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class WishlistRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'user_id' => 'required',
          'product_id' => 'required',
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
          // user id
          'user_id.required' => trans('icommerce::common.messages.field required'),
  
          // product id
          'product_id.required' => trans('icommerce::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
