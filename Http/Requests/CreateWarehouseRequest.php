<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateWarehouseRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'lat' => 'required|min:2',
            'lng' => 'required|min:2',
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
        return [];
    }

    public function translationMessages()
    {
        return [];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
    
}
