<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ProductListRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'product_id' => 'required',
          'price_list_id' => 'required',

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
          // Product Id
          'product_id.required' => trans('icommerce::common.messages.field required'),
  
          // Price List Id
          'price_list_id.required' => trans('icommerce::common.messages.field required'),
          
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
