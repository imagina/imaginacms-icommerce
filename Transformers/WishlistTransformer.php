<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class WishlistTransformer extends Resource
{
    public function toArray($request)
    {
        /*valida la imagen del producto*/
        if (isset($this->product()->options->mainimage) && !empty($this->product()->options->mainimage)){
            $image = url($this->product()->options->mainimage);
        }else{
            $image = url('modules/icommerce/img/product/default.jpg');
        }
        
        /*datos*/
        return  [
            'id' => $this->product()->id,
            'title' => $this->product()->title,
            'slug' => $this->product()->slug,
            'url' => $this->product()->url,
            'description' => $this->product()->description,
            'summary' => $this->product()->summary,
            'price' => formatMoney($this->product()->price),
            'mainimage' => $image,
            'gallery' => $this->product()->gallery
        ];
    }
}