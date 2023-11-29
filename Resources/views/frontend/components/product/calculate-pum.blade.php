@php

    //validation to partial param
    if(!isset($dynamicPrice)) $dynamicPrice = null;
    //currency from index or show variable
    $currencySymbol = isset($currency) ? $currency->symbol_left : '$';
    //get pum for this product
    $pum = $product->present()->getCalculateInfor($currencySymbol,$dynamicPrice);

@endphp

@if(!empty($pum))
    <div class="calculate-pum w-100 mb-2">
        <small>({{$pum}})</small>
    </div>
@endif