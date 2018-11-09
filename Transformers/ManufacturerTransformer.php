<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;


class ManufacturerTransformer extends Resource
{
    public function toArray($request)
    {
        $includes = explode(",", $request->include);
        if (isset($this->options->mainimage) && !empty($this->options->mainimage)) {
            $image = url($this->options->mainimage);
        } else {
            $image = url('modules/icommerce/img/product/default.jpg');
        }
        /*datos*/
        $data= [
            'id' => $this->id,
            'name' => $this->name,
            //'url' => $this->url,
            'mainimage' => $image,
            'catalog'=>$this->options->catolog??''
        ];

        if (in_array('products', $includes)) {
            $data['productss'] =  ProductTransformer::collection($this->products);
        }
    }
}