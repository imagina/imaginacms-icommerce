<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CategoryTransformer extends Resource
{
    public function toArray($request)
    {
        if (isset($this->options->mainimage) && !empty($this->options->mainimage)) {
            $image = url($this->options->mainimage);
        } else {
            $image = url('modules/icommerce/img/product/default.jpg');
        }
        /*datos*/
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->url,
            'description' => $this->description,
            'mainimage' => $image,
            'parent'=>new CategoryTransformer($this->parent)
        ];
    }
}