<div class="card card-block p-3 shippingMethods mb-3">
  <div class="row m-0 card-number-text">
    <div class="number-check"> {{$step}} </div>
    <h3 class="d-flex align-items-center my-1 h5">
       {{ trans('icommerce::shippingmethods.title.shippingmethods') }}
    </h3>
    @if($errors->has('shippingMethod'))
      <br/>
      <span class="alert alert-danger" role="alert">{{ $errors->first('shippingMethod') }}</span>
    @endif
  </div>
  <hr class="my-2"/>
  <div class="row">
    <div class="col">
     @include("icommerce::frontend.livewire.checkout.partials.shipping-methods-list")
    </div>
  </div>
</div>
