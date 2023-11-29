<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class StoreRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'name' => 'required|min:2',
            'address'=> 'required|min:2',
            'phone' => 'required|min:2',
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
        return [
            // name
            'name.required' => trans('icommerce::common.messages.field required'),
            'name.min:2' => trans('icommerce::common.messages.min 2 characters'),

            // address
            'address.required' => trans('icommerce::common.messages.field required'),
            'address.min:2' => trans('icommerce::common.messages.min 2 characters'),

            // phone
            'phone.required' => trans('icommerce::common.messages.field required'),
            'phone.min:2' => trans('icommerce::common.messages.min 2 characters'),
        ];
    }
}
