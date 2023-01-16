@php($step = 3)
@if($requireShippingMethod)
  <div id="cardShippingAddress" class="card card-block p-3 mb-3">
    <div class="row m-0">
      <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
        {{ config('asgard.icommerce.config.infoCardCheckout.shippingDetails.numberPosition')}}
      </div>
      <h3 class="d-flex align-items-center h5">
        {{ trans('icommerce::delivery_details.title') }}
      </h3>
      
      @if($errors->has('shippingAddress'))
        <br/>
        <span class="alert alert-danger" role="alert">{{ $errors->first('shippingAddress') }}</span>
      @endif
    </div>
    
    <hr class="my-2"/>
    
    @include("icommerce::frontend.livewire.checkout.partials.shipping-details")
  </div>
  @php($step++)
@endif
