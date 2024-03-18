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
        <label>{{$option->description}}
            : {{$option->pivot->value}}</label>
    @endforeach
@endif