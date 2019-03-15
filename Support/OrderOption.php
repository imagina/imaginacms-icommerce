<?php

namespace Modules\Icommerce\Support;

class OrderOption
{

  public function fixData($orderID,$orderItemID,$productOption){

    $data['order_id'] = $orderID;
    $data['order_item_id'] = $orderItemID;

    $parentOptionValue = "";
    $optionValue = "";

    //Is multiple Options (Like select) - ProductOptionValue
    if($productOption->pivot->product_option_value_id!=null){

      $productOptionValue = $productOption->productOptionValues->find($productOption->pivot->product_option_value_id);
      
      // Validate Parent
      if($productOptionValue->parent)
        $parentOptionValue = $productOptionValue->parent->optionValue->description;
      
      // Get Option Value
      $optionValue = $productOptionValue->optionValue->description;

      // Values from Product Option Value
      $data['price'] = $productOptionValue->price;
      $data['price_prefix'] = $productOptionValue->price_prefix;
      $data['points'] = $productOptionValue->points;
      $data['points_prefix'] = $productOptionValue->points_prefix;
      $data['weight'] = $productOptionValue->weight;
      $data['weight_prefix'] = $productOptionValue->weight_prefix;

    }else{
    
      // Is Single - ProductOption

      // Validate Parent
      if($productOption->parent)
        $parentOptionValue = $productOption->parent->optionValue->description;

      // Get Option Value
      $optionValue = $productOption->optionValue->description;

    }

    $data['parent_option_value'] = $parentOptionValue;
    $data['option_value'] = $optionValue;

    $data['value'] = $productOption->value;
    $data['required'] = $productOption->required;


    return $data;
    
    
  }


}