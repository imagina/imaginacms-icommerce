<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductTransformer extends Resource
{
    public function toArray($request)
    {

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
        $price_discount = $this->discount;
        if ($price_discount) {
            $discount = '-' . intVal((($this->price - $price_discount) / $this->price) * 100) . '%';
            $price_discount = number_format($price_discount, 2);
        } else {
            $discount = false;
        }

        /*datos*/

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->url,
            'description' => $this->description,
            'summary' => $this->summary,
            'price' => number_format($this->price, 2),
            'price_discount' => $price_discount,
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
            'category' => new CategoryTransformer($this->category),
        ];
    }
}