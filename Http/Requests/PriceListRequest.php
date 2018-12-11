<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class PriceListRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'criteria' => 'required'
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
          // criteria
          'criteria.required' => trans('icommerce::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
          // Name
          'name.required' => trans('icommerce::common.messages.field required'),
          'name.min:2' => trans('icommerce::common.messages.min 2 characters'),

        ];
    }
}
