<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

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

    $data['price'] = $this->discount->price ?? $this->priceByList ?? $this->price;


    $this->entityRelation($data);

    return $data;
  }


  private function entityRelation(&$data){

    if(!empty($this->entity_type) && !empty($this->entity_id)){

      $entity = $this->entity_type::find($this->entity_id);

      if(!empty($entity) && !empty($entity->transformer)){

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
