<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateProductDiscountRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'discount' => 'required',
            'date_start' => 'required|date_format:Y/m/d',
            'date_end' => 'required|date_format:Y/m/d'
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
