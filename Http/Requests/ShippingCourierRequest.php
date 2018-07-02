<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class ShippingCourierRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
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
            'code' => 'required|min:2',
            'name' => 'required|min:2',
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
            'code.required' => 'Code es requerido',
            'code.min:2'=> 'El code no puede tener menos de dos caracteres',
            'name.required'=> 'Nombre requerido',
            'name.min:2'=> 'El nombre no debe tener menos de dos caracteres',
        ];
    }
}