<?php


/**
 * Get Total Weight for All items validing freeshipping
 *
 * @param  Collection $items
 * @param  String $countryCode // Destiny
 * @return Float
 */
if (!function_exists('icommerce_getTotalWeight')) {

    function icommerce_getTotalWeight($items, $countryCode, $freeshipping = 0)
    {

        $countryFree = "";

        // If Country freeshipping is Null that's no matter
        // because in the validation the $countryCode!=$countryFree
        // the weight would be added
        if (setting('icommerce::country-freeshipping')) {
            $countryFree = setting('icommerce::country-freeshipping');
        }

        $totalWeight = 0;

        foreach ($items as $key => $item) {
            $weightItem = 0;

            // The product don't have freeshipping = 0
            if ($item->freeshipping == $freeshipping) {
                $weightItem = ($item->weight > 0) ? $item->weight : 1;
                $totalWeight = $totalWeight + ($weightItem * $item->quantity);
            } else {

                // The product has freeshipping
                // and country destiny it's not the freeshipping Country
                if ($item->freeshipping == 1 && $countryCode != $countryFree) {
                    $weightItem = ($item->weight > 0) ? $item->weight : 1;
                    $totalWeight = $totalWeight + ($weightItem * $item->quantity);
                }

            }
        }

        return $totalWeight;
    }

}

/**
 * Get Total Dimensions from All Products in the cart
 *
 * @param  Collection $items
 * @return Array $dimensions
 */

if (!function_exists('icommerce_totalDimensions')) {

    function icommerce_totalDimensions($items)
    {

        $tWidth = 0;
        $tHeight = 0;
        $tLength = 0;

        foreach ($items as $key => $item) {

            $tWidth += ($item->width > 0) ? $item->width : 1;
            $tHeight += ($item->height > 0) ? $item->height : 1;
            $tLength += ($item->length > 0) ? $item->length : 1;

        }

        $dimensions = array($tWidth, $tHeight, $tLength);

        return $dimensions;

    }

}
