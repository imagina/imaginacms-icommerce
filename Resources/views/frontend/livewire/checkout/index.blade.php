<div id="checkout" class="page checkout checkout-tabs" wire:init="init">
  

  
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="text-title text-center mb-5">
          <h1 class="title">{{$title}}</h1>
        </div>
      </div>
    </div>
  </div>
  
  <!-- ======== @Region: #content ======== -->
  <div id="content" class="pb-5 position-relative">
    @include('isite::frontend.partials.preloader')
    @if(!$cartEmpty)
      <div class="container">
        @include("icommerce::frontend.livewire.checkout.layouts.$layout.index",
        [
          "billingAddress" => $this->billingAddress,
          "paymentMethod" => $this->paymentMethod,
          "shippingAddress" => $this->shippingAddress,
          "shippingMethod" => $this->shippingMethod,
          "totalTaxes" => $this->totalTaxes,
          "total" => $this->total,
          ])
      </div>
    @else
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="alert alert-primary" role="alert">
              {{ trans('icommerce::checkout.no_products_1') }}
              <a href="{{ url('/') }}" class="alert-link">
                {{ trans('icommerce::checkout.no_products_here') }}
              </a>
              {{ trans('icommerce::checkout.no_products_2') }}
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>


</div>

@section("scripts")
  @parent
  <script type="text/javascript" defer>
    Livewire.on('orderCreated', orderData => {
      //Redirect to Cordova mode
      if (navigator.userAgent.match(/Cordova/i)) {
        //Redirect to payment method
        if (orderData.external) window.open(encodeURI(orderData.redirectRoute), '_system', 'location=yes')
        //Redirect to order page TODO: check fix to work with cordova
        //window.open(orderData.url, '_self')
      } else {//Redirect web browser mode
        //Redirect to payment method
        if (orderData.external) window.location.replace(orderData.redirectRoute)
        else window.location.replace(orderData.url)
        //Redirect to order page
        
      }
    })
  </script>
@stop
