  @foreach($shippingMethods as $key => $shippingMethod)

    @php
      $disableMethod=false;
      if(isset($shippingMethod->calculations->status) && $shippingMethod->calculations->status=="error")
        $disableMethod = true;
      
    @endphp

    <div class="card mb-0 border-0">
      <div class="card-header bg-white" role="tab" id="headingOne">
        <label class="mb-0">
          <input type="radio" class="form-check-input" name="shipping_method"
                 value="{{$shippingMethod->id}}"
                 wire:model="shippingMethodSelected" @if($disableMethod) disabled @endif>

          {{$shippingMethod->title}}
        </label>
        @php($mediaFiles = $shippingMethod->mediaFiles())
        @if(isset($mediaFiles->mainimage->relativeMediumThumb) && !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
          <img src="{{$mediaFiles->mainimage->relativeMediumThumb}}" class="img-responsive float-right" style="max-height: 100px; width: auto; max-width: 60%;">
        @endif

        
        @if(!$disableMethod && $shippingMethod->calculations)
          @if(isset($shippingMethod->calculations->priceshow) && $shippingMethod->calculations->priceshow)
            <div class="shipping-method-price">

              Precio:
              {{ isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney($shippingMethod->calculations->price) }} {{isset($currency) ? $currency->symbol_right : ''}}

            </div>
          @endif
        @endif
        

      </div>

      
      @if($disableMethod)
        <div class="shipping-method-error">
          <div class="alert alert-danger" role="alert">
            {{$shippingMethod->calculations->msj}}
          </div>
        </div>
      @endif

      <div class="card-block">
        {!! $shippingMethod->description !!}
      </div>

    </div>

  @endforeach
