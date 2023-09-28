<?php

namespace Modules\Icommerce\Support;

class OrderOption
{
    public function fixData($orderID, $orderItemID, $productOptionValue)
    {
        $data['order_id'] = $orderID;
        $data['order_item_id'] = $orderItemID;

        $parentOptionValue = '';
        $optionValue = '';

        // Get Option Value
        $optionValue = '';
        if ($productOptionValue->option) {
            $optionValue = $productOptionValue->option->description;
        }

        if ($productOptionValue->optionValue) {
            $optionValueDescription = $productOptionValue->optionValue->description;
        }

        if ($productOptionValue->parentOptionValue) {
            $parentOptionValue = $productOptionValue->parentOptionValue->description;
        }

        // Values from Product Option Value
        $data['price'] = $productOptionValue->price;
        $data['price_prefix'] = $productOptionValue->price_prefix;
        $data['points'] = $productOptionValue->points;
        $data['points_prefix'] = $productOptionValue->points_prefix;
        $data['weight'] = $productOptionValue->weight;
        $data['weight_prefix'] = $productOptionValue->weight_prefix;

        $data['parent_option_value'] = $parentOptionValue;
        $data['option_description'] = $optionValue;
        $data['option_value_description'] = $optionValueDescription;

        $data['value'] = $productOptionValue->productOption->value;
        $data['required'] = $productOptionValue->productOption->required;

        return $data;
    }
}
