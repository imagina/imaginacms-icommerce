@if($requireShippingMethod)
  <div id="cardShippingMethods" class="card card-block p-3 shippingMethods mb-3">
    <div class="row">
      <div class="col">
        <div class="row m-0">
          <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
            {{ config('asgard.icommerce.config.infoCardCheckout.shippingMethods.numberPosition')}}
          </div>
          <h3 class="d-flex align-items-center h5">
            {{trans('icommerce::shippingmethods.title.shippingmethods') }}
          </h3>
          @if($errors->has('shippingMethod'))
            <br/>
            <span class="alert alert-danger" role="alert">{{ $errors->first('shippingMethod') }}</span>
          @endif
        </div>
        
        @include("icommerce::frontend.livewire.checkout.partials.shipping-methods-list")
      </div>
    </div>
  </div>
@endif
