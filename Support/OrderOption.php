<?php

namespace Modules\Icommerce\Support;

use Modules\Icommerce\Entities\ProductOption;

class OrderOption
{
  
  public function fixData($orderID, $orderItem, $productOptionValue=null, $option = null)
  {
    
    $data['order_id'] = $orderID;
    $data['order_item_id'] = $orderItem->id;
    
    $parentOptionValue = "";
    $optionValue = "";
    
    //Case Dynamics Options
    $productOption= null;
    if(!is_null($option)){
      $productOption = ProductOption::where(['option_id'=> $option->id, 'product_id' => $orderItem->product_id ])->first();
    }

    // Get Option Value
    $optionValue = $productOptionValue->option->description ?? $option->description ?? '';
    $optionValueDescription = $productOptionValue->optionValue->description ?? $option->pivot->value ?? ''; //Pivot is CartProductOption
    $parentOptionValue = $productOptionValue->parentOptionValue->description ?? $productOption->parentOptionValue->description ?? '';

    // Values from Product Option Value
    if(!is_null($productOptionValue)){
      $data['price'] = $productOptionValue->price;
      $data['price_prefix'] = $productOptionValue->price_prefix;
      $data['points'] = $productOptionValue->points;
      $data['points_prefix'] = $productOptionValue->points_prefix;
      $data['weight'] = $productOptionValue->weight;
      $data['weight_prefix'] = $productOptionValue->weight_prefix;
    }
    
    //Set Data
    $data['parent_option_value'] = $parentOptionValue;
    $data['option_description'] = $optionValue;
    $data['option_value_description'] = $optionValueDescription;
    $data['value'] = $productOptionValue->productOption->value ?? $option->value ?? '';
    $data['required'] = $productOptionValue->productOption->required ??  $productOption->required ?? '';

    $data['option_id'] = $productOptionValue->option->id ?? $option->id ?? null;
    $data['option_value_id'] =  $productOptionValue->optionValue->id ?? $option->value->id ?? null;

    //Options General from Product Options Value
    $data['options'] =  $productOptionValue->options ?? null;

   
    //Add pOV->id in options
    if(!is_null($productOptionValue)){
        $data['options']['productOptionValueId'] = $productOptionValue->id;
    }

    return $data;
    
    
  }
  
  
}