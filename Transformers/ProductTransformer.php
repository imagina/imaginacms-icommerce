<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Entities\Manufacturer;

class ProductTransformer extends Resource
{
    public function toArray($request)
    {

        $includes = explode(",", $request->include);
        /*evalua segun si el pruducto es nuevo o no (15 días)*/
        $date1 = date_create($this->date_available);
        $date2 = date_create(date("Y/m/d"));
        $diff = date_diff($date1, $date2); //diferencia de dias

        /*valida la imagen del producto*/
        if (isset($this->options->mainimage) && !empty($this->options->mainimage)) {
            $image = url($this->options->mainimage);
        } else {
            $image = url('modules/icommerce/img/product/default.jpg');
        }

        /*valida la imagen del producto*/
        if (isset($this->options->mainfile) && !empty($this->options->mainfile)) {
            $pdf = url($this->options->mainfile);
        } else {
            $pdf = false;
        }

        /*obtiene el descuento que este activo por producto*/
        $price_discount = $this->product_discounts()->where('date_start' ,'<=', date('Y-m-d'))->where('date_end' ,'>=', date('Y-m-d'))->first()->price ?? null;

        if ($price_discount) {
            $price=$this->price!=='0.00'?$this->price:1;
            $discount = '-' . intVal((($this->price - $price_discount) / $price) * 100) . '%';
        } else {
            $discount = false;
        }

        /*datos*/

        $data= [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->url,
            'description' => $this->description,
            'summary' => $this->summary,
            'price' => formatMoney($this->price),
            'unformatted_price' => $this->price,
            'unformatted_price_discount' => $price_discount,
            'price_discount' => formatMoney($price_discount),
            'discount' => $discount,
            'new' => $diff->days > 15 ? false : true,
            'rating' => $this->rating,
            'mainimage' => $image,
            'product_discounts' => empty($this->product_discounts) ? 0 : $this->product_discounts,
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'gallery' => count($this->gallery) >= 1 ? $this->gallery : false,
            'sku' => $this->sku,
            'pdf' => $pdf,
            'quantity_cart' => 0,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'freeshipping' => $this->freeshipping,
            'options'=>ProductOptionsTransformer::collection($this->optionsv),
        ];

        /*Transform Relation Ships*/
        if (in_array('category', $includes)) {
            $data['category'] = new CategoryTransformer($this->category);
        }

        if (in_array('categories', $includes)) {
            $data['categories'] =  CategoryTransformer::collection($this->categories);
        }

        if (in_array('tags', $includes)) {
            $data['tags'] = TagTransformer::collection($this->tags);
        }
        if (in_array('manufacturer', $includes)) {
            $data['manufacturer'] = new ManufacturerTransformer($this->manufacturer);
        }
        if (in_array('children', $includes)) {
            $data['children'] = ProductTransformer::collection($this->children);
        }
        if (in_array('parent', $includes)) {
            $data['parent'] = new ProductTransformer($this->parent);
        }

        /*Return Data*/
        return $data;
    }
}
