<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OptionTransformer extends Resource
{
    public function toArray($request)
    {
        // if (isset($this->options->mainimage) && !empty($this->options->mainimage)) {
        //     $image = url($this->options->mainimage);
        // } else {
        //     $image = url('modules/icommerce/img/product/default.jpg');
        // }
        /*datos*/
        return  [
            'id' => $this->id,
            'type' => $this->type,
            'description' => $this->description,
            'option_value'=>OptionValueTransformer::collection($this->option_values),
        ];
    }
}
