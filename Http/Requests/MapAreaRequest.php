<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class MapAreaRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'polygon' => 'required|min:2',
            'store_id' => 'required|min:2',
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
            // polygon
            'polygon.required' => trans('icommerce::common.messages.field required'),
            'polygon.min:2' => trans('icommerce::common.messages.min 2 characters'),

            // store_id
            'store_id.required' => trans('icommerce::common.messages.field required'),
            'store_id.min:2' => trans('icommerce::common.messages.min 2 characters'),

        ];
    }
}
