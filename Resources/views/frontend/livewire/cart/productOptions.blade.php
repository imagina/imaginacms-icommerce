@if($cartProduct->productOptionValues->count())
    <br>
    @foreach($cartProduct->productOptionValues as $productOptionValue)
        <label>{{$productOptionValue->option->description}}
            : {{$productOptionValue->optionValue->description}}</label>
    @endforeach
@endif

@if($cartProduct->optionsDynamics)
    <br>
    @foreach($cartProduct->optionsDynamics as $option)
        <label>{{$option->description}}
            : {{$option->pivot->value}}</label>
    @endforeach
@endif