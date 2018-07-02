<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class IcommerceRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
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
            'title' => 'required|min:2',
            'description' => 'required|min:2',
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
            'title.required' => trans('icommerce::common.messages.title is required'),
            'title.min:2'=> trans('icommerce::common.messages.title min 2 '),
            'description.required'=> trans('icommerce::common.messages.description is required'),
            'description.min:2'=> trans('icommerce::common.messages.description min 2 '),
        ];
    }
}