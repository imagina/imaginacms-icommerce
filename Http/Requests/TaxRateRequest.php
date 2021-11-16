<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class TaxRateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'rate' => 'required',
          'type' => 'required',
          //'geozone_id' => 'required',
          //'tax_class_id' => 'required'
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
          // rate
          'rate.required' => trans('icommerce::common.messages.field required'),

          // type
          'type.required' => trans('icommerce::common.messages.field required'),

          // geozone id
          'geozone_id.required' => trans('icommerce::common.messages.field required'),

          // tax_class_id
          //'tax_class_id.required' => trans('icommerce::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
          // name
          'name.required' => trans('icommerce::common.messages.field required'),
          'name.min:2' => trans('icommerce::common.messages.min 2 characters'),
        ];
    }
}
