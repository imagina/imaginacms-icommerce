<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CouponRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'code' => 'required|min:2',
          'discount' => 'required|min:2',
          'date_start' => 'required',
          'date_end' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
          'title' => 'required|min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
          // code
          'code.required' => trans('icommerce::common.messages.field required'),
          'code.min:2' => trans('icommerce::common.messages.min 2 characters'),

          // discount
          'discount.required' => trans('icommerce::common.messages.field required'),
          'discount.min:2' => trans('icommerce::common.messages.min 2 characters'),

          // total
          'total.required' => trans('icommerce::common.messages.field required'),

          // date start
          'date_start.required' => trans('icommerce::common.messages.field required'),

          // date end
          'date_end.required' => trans('icommerce::common.messages.field required'),

          // uses total
          'uses_total.required' => trans('icommerce::common.messages.field required'),

        ];
    }

    public function translationMessages()
    {
        return [
          // title
          'title.required' => trans('icommerce::common.messages.field required'),
          'title.min:2' => trans('icommerce::common.messages.min 2 characters'),

        ];
    }
}
