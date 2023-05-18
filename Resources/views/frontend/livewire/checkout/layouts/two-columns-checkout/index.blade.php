<div id="btn-continue-buying-up" class="row">
  <div class="col py-2">
    <a class="btn btn-primary waves-effect waves-light"
       href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-6 col-lg-8">
    @include('icommerce::frontend.livewire.checkout.layouts.two-columns-checkout.customer')
    @include('icommerce::frontend.livewire.checkout.layouts.two-columns-checkout.billing-details')
    @php($step = 3)
    @if($requireShippingMethod)
      @include('icommerce::frontend.livewire.checkout.layouts.two-columns-checkout.shipping-details')
      @php($step++)
    @endif
    @if($requireShippingMethod)
      @include('icommerce::frontend.livewire.checkout.layouts.two-columns-checkout.shipping-methods')
      @php($step++)
    @endif
    @include('icommerce::frontend.livewire.checkout.layouts.two-columns-checkout.payment-methods')
  </div>

  <div class="col-12 col-md-6 col-lg-4">
    <div class="sticky-top">
    @include('icommerce::frontend.livewire.checkout.partials.order-summary')
    </div>
  </div>
</div>

<div class="row">
  <div class="col py-2">
    <a class="btn btn-primary" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

