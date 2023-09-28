<?php

namespace Modules\Icommerce\Support;

use Modules\Icommerce\Entities\ProductDiscount;

class OrderItem
{
    public function fixData($items)
    {
        $products = [];

        foreach ($items as $item) {
            array_push($products, [
                'product_id' => (int) $item->product_id,
                'organization_id' => $item->product->organization_id ?? null,
                'title' => $item->product->name,
                'reference' => $item->product->sku,
                'quantity' => (int) $item->quantity,
                'price' => floatval($item->product->price),
                'total' => $item->total,
                'discount' => $item->product->discount ?? null,
                'options' => $item->options,
                'entity_type' => $item->product->entity_type ?? null,
                'entity_id' => $item->product->entity_id ?? null,
                'tax' => 0,
                'reward' => 0,
                'productOptionValues' => (count($item->productOptionValues) > 0) ? $item->productOptionValues : null,
            ]);

            if (isset($item->product->discount->id)) {
                $productDiscount = ProductDiscount::find($item->product->discount->id);
                $productDiscount->quantity_sold += (int) $item->quantity;
                $productDiscount->save();
            }
        }

        return $products;
    }
}
