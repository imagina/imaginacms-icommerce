@if($cartProduct->productOptionValues->count())
  <br>
  @foreach($cartProduct->productOptionValues as $productOptionValue)
    <label>{{$productOptionValue->option->description}}
      : {{$productOptionValue->optionValue->description}}</label>
  @endforeach
@endif

@if($cartProduct->cartProductOptions)
  <br>
  @foreach($cartProduct->cartProductOptions as $cartOption)
    @if($cartOption->option)
    <label>{{$cartOption->option->description ?? '-'}}
      : {{$cartOption->dynamicProductOptionValue->OptionValue->description ?? '-'}}</label>
    @endif
  @endforeach
@endif
