<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class OptionRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{
     public function rules()
    {
        return [
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
            'description.required' => trans('icommerce::common.messages.description is required'),
            'description.min:2'=> trans('icommerce::common.messages.description min 2 '),
        ];
    }

   
}
