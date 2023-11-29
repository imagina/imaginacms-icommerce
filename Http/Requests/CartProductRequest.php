<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CartProductRequest extends BaseFormRequest
{
    public function rules()
    {
      return [
        'cart_id' => 'required|exists:icommerce__carts,id',
        'product_id' => 'required|exists:icommerce__products,id',

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
        // cart id
        'cart_id.required' => trans('icommerce::common.messages.field required'),

        // product id
        'product_id.required' => trans('icommerce::common.messages.field required'),
        
      ];
    }

    public function translationMessages()
    {
        return [];
    }
}
