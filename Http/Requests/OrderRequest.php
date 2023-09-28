<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class OrderRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'total' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'payment_first_name' => 'required',
            'payment_last_name' => 'required',
            'payment_address_1' => 'required',
            'payment_city' => 'required',
            'payment_zip_code' => 'required',
            'payment_country' => 'required',
            'payment_method' => 'required',
            'payment_code' => 'required',
            'shipping_first_name' => 'required',
            'shipping_last_name' => 'required',
            'shipping_address_1' => 'required',
            'shipping_city' => 'required',
            'shipping_zip_code' => 'required',
            'shipping_country_code' => 'required',
            'shipping_method' => 'required',
            'shipping_code' => 'required',
            'ip' => 'required',
            'store_id' => 'required',
            // 'store_name' => 'required',
            // 'store_address' => 'required',
            // 'store_phone' => 'required',
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
            // Total
            'total.required' => trans('icommerce::common.messages.field required'),

            // First Name
            'first_name.required' => trans('icommerce::common.messages.field required'),

            // Last Name
            'last_name.required' => trans('icommerce::common.messages.field required'),

            // Email
            'email.required' => trans('icommerce::common.messages.field required'),

            // Payment First Name
            'payment_first_name.required' => trans('icommerce::common.messages.field required'),

            // Payment Last Name
            'payment_last_name.required' => trans('icommerce::common.messages.field required'),

            // Payment Address 1
            'payment_address_1.required' => trans('icommerce::common.messages.field required'),

            // Payment City
            'payment_city.required' => trans('icommerce::common.messages.field required'),

            // Payment Zip Code
            'payment_zip_code.required' => trans('icommerce::common.messages.field required'),

            // Payment Country
            'payment_country.required' => trans('icommerce::common.messages.field required'),

            // Payment Method
            'payment_method.required' => trans('icommerce::common.messages.field required'),

            // Payment Code
            'payment_code.required' => trans('icommerce::common.messages.field required'),

            // Shipping First Name
            'shipping_first_name.required' => trans('icommerce::common.messages.field required'),

            // Shipping Last Name
            'shipping_last_name.required' => trans('icommerce::common.messages.field required'),

            // Shipping Address 1
            'shipping_address_1.required' => trans('icommerce::common.messages.field required'),

            // Shipping City
            'shipping_city.required' => trans('icommerce::common.messages.field required'),

            // Shipping Zip Code
            'shipping_zip_code.required' => trans('icommerce::common.messages.field required'),

            // Uses Total
            'uses_total.required' => trans('icommerce::common.messages.field required'),

            // Shipping Country
            'shipping_country.required' => trans('icommerce::common.messages.field required'),

            // Shipping Method
            'shipping_method.required' => trans('icommerce::common.messages.field required'),

            // Shipping Code
            'shipping_code.required' => trans('icommerce::common.messages.field required'),

            // Ip
            'ip.required' => trans('icommerce::common.messages.field required'),

            // Store Id
            'store_id.required' => trans('icommerce::common.messages.field required'),

            // Store Name
            'store_name.required' => trans('icommerce::common.messages.field required'),

            // Store Address
            'store_address.required' => trans('icommerce::common.messages.field required'),

            // Store Phone
            'store_phone.required' => trans('icommerce::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
