  @foreach($shippingMethods as $key => $shippingMethod)
    <div class="card mb-0 border-0">
      <div class="card-header bg-white" role="tab" id="headingOne">
        <label class="mb-0">
          <input type="radio" class="form-check-input" name="shipping_method"
                 value="{{$shippingMethod->id}}"
                 wire:model.defer="paymentMethodSelected">
    
          {{$shippingMethod->title}}
        </label>
        @php($mediaFiles = $shippingMethod->mediaFiles())
        @if(isset($mediaFiles->mainimage->relativeMediumThumb) && !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
          <img src="{{$mediaFiles->mainimage->relativeMediumThumb}}" class="img-responsive float-right" style="max-height: 100px; width: auto; max-width: 60%;">
        @endif
      </div>
      <div class="card-block">
        {!! $shippingMethod->description !!}
      </div>

    </div>

  @endforeach