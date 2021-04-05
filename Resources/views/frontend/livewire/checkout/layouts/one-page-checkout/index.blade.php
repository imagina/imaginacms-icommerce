<div class="row">
  <div class="col py-2">
    <a class="btn btn-success waves-effect waves-light"
       href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

<div class="row">
  
  <div class="col-12 col-md-6 col-lg-4">
    @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.customer')
  </div>
  
  <div class="col-12 col-md-6 col-lg-4">
    @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.billing_details')
    
    @php($step = 3)
    @if($requireShippingMethod)
      @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.shipping_details')
      @php($step++)
    @endif
  </div>
  
  <div class="col-12 col-md-12 col-lg-4">
    
    @if($requireShippingMethod)
      @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.shipping_methods')
      @php($step++)
    @endif
    
    @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.payment_methods')
    @include('icommerce::frontend.livewire.checkout.partials.order_summary')
  
  </div>

</div>

<div class="row">
  <div class="col py-2">
    <a class="btn btn-success" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

