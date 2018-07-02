<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{

    public function rules()
    {
        return [
            'title' => 'required|min:2',
            'description' => 'required|min:2',
        ];
    }


    public function authorize()
    {
        return true;
    }


    public function attributes()
    {
        return [
            //
        ];
    }


    public function messages()
    {
        return [
            'title.required' => trans('icommerce::common.messages.title is required'),
            'title.min:2'=> trans('icommerce::common.messages.title min 2 '),
            'description.required' => trans('icommerce::common.messages.description is required'),
            'description.min:2'=> trans('icommerce::common.messages.description min 2 '),
        ];
    }

   
}
