<div class="card-ckeckout card-shipping-methods mb-3">

  <h4 class="ckeckout-subtitle my-1 font-weight-bold">
    {{ trans('icommerce::shippingmethods.title.shippingmethods') }}
  </h4>
  @if($errors->has('shippingAddress'))
    <br/>
    <span class="alert alert-danger" role="alert">{{ $errors->first('shippingAddress') }}</span>
  @endif
  @if($errors->has('shippingMethod'))
    <br/>
    <span class="alert alert-danger" role="alert">{{ $errors->first('shippingMethod') }}</span>
  @endif
  @include("icommerce::frontend.livewire.checkout.partials.shipping-methods-list")
</div>