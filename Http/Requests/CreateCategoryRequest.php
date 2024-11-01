<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class CreateCategoryRequest extends BaseFormRequest
{
  public function rules()
  {
    return [];
  }

  public function translationRules()
  {
    return [
      'title' => 'required|min:2',
      'slug' => ['required', new UniqueSlugRule('icommerce__category_translations'), 'min:2',"alpha_dash:ascii"],
      'description' => 'required|min:2',
    ];
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
    return [
      // title
      'title.required' => trans('icommerce::common.messages.field required'),
      'title.min:2' => trans('icommerce::common.messages.min 2 characters'),

      // slug
      'slug.required' => trans('icommerce::common.messages.field required'),
      'slug.min:2' => trans('icommerce::common.messages.min 2 characters'),

      // description
      'description.required' => trans('icommerce::common.messages.field required'),
      'description.min:2' => trans('icommerce::common.messages.min 2 characters'),
    ];
  }

  public function getValidator()
  {
    return $this->getValidatorInstance();
  }
}