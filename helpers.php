<?php

use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Entities\Status;

/**
 * Get Total Weight for All items validing freeshipping
 *
 * @param  Collection  $items
 * @param  string  $countryCode // Destiny
 * @return float
 */
if (! function_exists('icommerce_getTotalWeight')) {
    function icommerce_getTotalWeight($items, $countryCode, $freeshipping = 0)
    {
        $countryFree = '';

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

if (! function_exists('icommerce_geCategories')) {
    function icommerce_geCategories($options = [])
    {
        $default_options = [
            'take' => 12, //Numero de posts a obtener,
            'order' => ['field' => 'created_at', 'way' => 'desc'], //orden de llamado
            'filter' => ['status' => 1],
        ];

        $options = array_replace_recursive($default_options, $options);
        $categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
        $params = json_decode(json_encode($options));

        return $categoryRepository->getItemsBy($params);
    }
}

/**
 * Get Total Dimensions from All Products in the cart
 *
 * @param  Collection  $items
 * @return array $dimensions
 */
if (! function_exists('icommerce_totalDimensions')) {
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

        $dimensions = [$tWidth, $tHeight, $tLength];

        return $dimensions;
    }
}

if (! function_exists('localesymbol')) {
    function localesymbol($code = 'USD')
    {
        $currency = Currency::where('code', $code)->whereStatus(Status::ENABLED)->first();
        if (! isset($currency)) {
            $currency = (object) [
                'symbol_left' => '$',
                'symbol_right' => '',
                'code' => 'USD',
                'value' => 1,
            ];
        }

        return $currency;
    }
}

if (! function_exists('formatMoney')) {
    function formatMoney($value, $showCurrencyCode = false)
    {
        $currency = currentCurrency();

        $value = $value * $currency->value;
        $numberFormatted = number_format($value, intval($currency->decimals) ?? 0, $currency->decimal_separator, $currency->thousands_separator);

        if ($showCurrencyCode) {
            $numberFormatted = $currency->symbol_left.$numberFormatted.$currency->symbol_right;
        }

        return $numberFormatted;
    }
}
if (! function_exists('currentCurrency')) {
    function currentCurrency()
    {
        //$currency = \Cache::store(config('cache.default'))->remember('currency_'.(tenant()->id ?? '').locale(), 60 * 60 * 24 * 30, function () {
            $currencyRepository = app("Modules\Icommerce\Repositories\CurrencyRepository");
            $params = ['filter' => ['language' => locale(), 'field' => 'status']];
            //getting currency by current locale
            $currency = $currencyRepository->getItem(Status::ENABLED, json_decode(json_encode($params)));

            if (! isset($currency->id)) {
                //getting default currency
                $params = ['filter' => ['default_currency' => 1, 'field' => 'status']];
                $currency = $currencyRepository->getItem(Status::ENABLED, json_decode(json_encode($params)));
            }

            if (! isset($currency->id)) {
                $currency = new Currency(Config::get('asgard.icommerce.config.formatMoney'));
            }

            //return $currency;
        //});

      //trycatching this request->session() because is failing when the request comes from API, this only works for blade session
      try{
        $sessionCurrency = request()->session()->get('custom_currency_' . (tenant()->id ?? ""));
      }catch(\Exception $e){

        }

   
      if(isset($sessionCurrency->id)) return $sessionCurrency;
        return $currency;
    }
}

/**
 * @param $base (weight,length,volume)
 */
if (!function_exists('getUnitClass')) {
  function getUnitClass($product,$base="weight"){
    $unit = "";

    $baseClass = $base."Class";

      $params = ['filter' => ['default' => 1],'include' => ['translations']];
        $repository = "Modules\Icommerce\Repositories\\".ucfirst($baseClass)."Repository";
        $default = app($repository)->getItemsBy(json_decode(json_encode($params)));
        if($default->isNotEmpty())
          $unit = $default[0]->unit;


    return $unit;
  }
}