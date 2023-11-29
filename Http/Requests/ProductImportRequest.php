<?php

namespace Modules\Icommerce\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ProductImportRequest extends BaseFormRequest
{
  public function rules()
  {
    return [
      'file' => 'required|file',
      'folderpaht' => 'nullable',
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
