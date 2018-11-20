<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateTaxRatesRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'name'=>'required|max:30',
          'rate'=>'required|numeric',
          'geozone_id','exists:ilocations__geozones,id'
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
}
