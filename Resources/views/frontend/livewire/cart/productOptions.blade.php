@if($cartProduct->productOptionValues->count())
  <br>
  @foreach($cartProduct->productOptionValues as $productOptionValue)
    <label>{{$productOptionValue->option->description}}
      : {{$productOptionValue->optionValue->description}}</label>
  @endforeach
@endif

@if($cartProduct->dynamicOptions)
  <br>
  @foreach($cartProduct->dynamicOptions as $option)
    @php
      $productOptionValueRepository = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
      $optionValueRepository = app('Modules\Icommerce\Repositories\OptionValueRepository');
      $productOptionValue = $productOptionValueRepository->getItem($option->pivot->value);
      $optionValue = $optionValueRepository->getItem($productOptionValue->option_value_id);
    @endphp
    <label>{{$option->description}}
      : {{$optionValue->description ?? $option->pivot->value}}</label>
  @endforeach
@endif
