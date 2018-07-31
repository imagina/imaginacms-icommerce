<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class CouponRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'code' => 'required|min:2',
            'type' => 'required',
            'discount' => 'required',
            'logged' => 'required',
            'shipping' => 'required',
            'total' => 'required',
            'uses_total' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('icommerce::common.messages.title is required'),
            'name.min:2'=> trans('icommerce::common.messages.title min 2 '),
            'code.required' => trans('icommerce::coupons.messages.code is required'),
            'type.required' => trans('icommerce::coupons.messages.field is required'),
            'discount.required' => trans('icommerce::coupons.messages.discount is required'),
            'logged.required' => trans('icommerce::coupons.messages.logged is required'),
            'shipping.required' => trans('icommerce::coupons.messages.shipping is required'),
            'total.required' => trans('icommerce::coupons.messages.total is required'),
            'uses_total.required' => trans('icommerce::coupons.messages.uses_total is required'),
            'date_start.required' => trans('icommerce::coupons.messages.date_start is required'),
            'date_end.required' => trans('icommerce::coupons.messages.date_end is required'),
        ];
    }
}