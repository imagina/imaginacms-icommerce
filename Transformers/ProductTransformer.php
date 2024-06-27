<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Icommerce\Transformers\ProductOptionPivotTransformer;

class ProductTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    $filter = json_decode($request->filter);
    $tags = [];
    foreach ($this->tags as $tag) {
      $tags[] = $tag->name;
    }
    $data = [
      'totalTaxes' => $this->getTotalTaxes($filter),
      'tags' => $tags,
      'productOptions' => ProductOptionPivotTransformer::collection($this->whenLoaded('productOptions')),
      'price' => $this->getRawOriginal('price'),
      'userPrice' => $this->discount->price ?? $this->price,
      'shipping' => $this->when($this->shipping, ((int)$this->shipping ? true : false)),
      'freeshipping' => $this->when($this->freeshipping, ((int)$this->freeshipping ? true : false)),
      'subtract' => $this->when($this->subtract, ((int)$this->subtract ? true : false)),
      'featured' => $this->featured ? '1' : '0',
      'isCall' => $this->is_call ? '1' : '0',
      'showPriceIsCall' => $this->show_price_is_call ? '1' : '0'
    ];

    $discount = $this->discount;
    if (isset($discount->id)) {
      $data["discount"] = new ProductDiscountTransformer($discount);
    }

    if (is_module_enabled('Icommercepricelist')) {
      $data['priceLists'] = \Modules\Icommercepricelist\Transformers\PriceListTransformer::collection($this->whenLoaded('priceLists'));
    } else {
      $data['priceLists'] = [];
    }

    $this->entityRelation($data);

    return $data;
  }


  private function entityRelation(&$data)
  {
    if (!empty($this->entity_type) && !empty($this->entity_id)) {
      $entity = $this->entity_type::find($this->entity_id);
      if (!empty($entity) && !empty($entity->transformer)) {
        $data["entity"] = new $entity->transformer($entity);
      }
    }
  }

  private function getTotalTaxes($filter)
  {
    $basePrice = $this->price ? $this->price : 0;
    $taxes = [];
    if (isset($this->taxClass) && isset($this->taxClass->rates)) {
      $taxes = $this->taxClass->rates;
      if (isset($filter->geozone)) {
        $taxes = $taxes->where('geozone_id', $filter->geozone);
      }
    }
    $totalTaxes = 0;
    foreach ($taxes as $tax) {
      $totalTaxes += floatval(($basePrice * $tax->rate) / 100);
    }
    return $totalTaxes;
  }
}
