<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class UpdateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            //'category_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'min:2',
            'slug' => [new UniqueSlugRule('icommerce__product_translations', $this->id, 'product_id'), 'min:2'],
            'description' => 'min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [

        ];
    }

    public function translationMessages()
    {
        return [
            // title
            'name.required' => trans('icommerce::common.messages.field required'),
            'name.min:2' => trans('icommerce::common.messages.min 2 characters'),

            // slug
            'slug.required' => trans('icommerce::common.messages.field required'),
            'slug.min:2' => trans('icommerce::common.messages.min 2 characters'),

            // description
            'description.required' => trans('icommerce::common.messages.field required'),
            'description.min:2' => trans('icommerce::common.messages.min 2 characters'),
        ];
    }
}
