<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class CommentRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{


    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|min:2',
            'status' => 'required'
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
            //'name.required' => trans('icommerce::common.messages.title is required'),

            //'name.min:2'=> trans('icommerce::common.messages.title min 2 '),

        ];

    }

}