@foreach($paymentMethods as $key => $paymentMethod)
  <div class="card mb-0 border-0">
    <div class="card-header bg-white" role="tab" id="headingOne">
      <label class="mb-0">
        <input type="radio" class="form-check-input" name="payment_method"
               value="{{$paymentMethod->id}}"
               wire:model.defer="paymentMethodSelected">
        
        {{$paymentMethod->title}}
      </label>
      @php($mediaFiles = $paymentMethod->mediaFiles())
      @if(isset($mediaFiles->mainimage->relativeMediumThumb) && !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
        <img src="{{$mediaFiles->mainimage->relativeMediumThumb}}" class="img-responsive float-right" style="max-height: 100px; width: auto; max-width: 60%;">
      @endif
    </div>
    
    <div class="card-block">
      {!! $paymentMethod->description !!}
    </div>
  
  </div>
@endforeach