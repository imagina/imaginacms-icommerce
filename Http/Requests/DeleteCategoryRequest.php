<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\DeleteFunctionRule;

class DeleteCategoryRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'id' => [new DeleteFunctionRule('icommerce__product_category', $this->id, 'category_id', trans('icommerce::common.messages.deleteValidation'))]
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

  public function validationData()
  {
    return array_merge($this->all(), [
      'id' => $this->query('id'),
    ]);
  }
}
