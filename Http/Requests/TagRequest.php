<?php

namespace Modules\Icommerce\Http\Requests;

use App\Http\Requests\Request;

class TagRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
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
            'title' => 'required|min:2'
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
            'title.required' => 'Titulo es requerido',
            'title.min:2'=> 'El titulo no puede tener menos de dos caracteres',
            'description.required'=> 'Descripción requerida',
            'description.min:2'=> 'La descripción no debe tener menos de dos caracteres',
        ];
    }
}