  <div id="checkout" class="page checkout checkout-one-page ">

    <x-isite::breadcrumb>
      <li class="breadcrumb-item active" aria-current="page">{{$title }}</li>
    </x-isite::breadcrumb>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="text-title text-center mb-5">
            <h1 class="title">{{ $title }}</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- ======== @Region: #content ======== -->
    <div id="content" class="pb-5 position-relative">
      <div class="container">
          @include('isite::frontend.partials.preloader')
        @if(!$cartEmpty)
            <div class="row">
              <div class="col py-2">
                <a class="btn btn-success waves-effect waves-light"
                   href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
              </div>
            </div>

            <div class="currency">

              <input type="hidden" name="currency_id" value="{{$currency->id}}">
              <input type="hidden" name="currency_code" value="{{$currency->code}}">
              <input type="hidden" name="currency_value" value="{{$currency->value}}">

            </div>

            <div class="row">

              <div class="col-12 col-md-6 col-lg-4">
                @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.customer')
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.billing_details',["billingAddress" => $this->billingAddress])

                  @php($step = 3)
                  @if($requireShippingMethod)
                    @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.shipping_details',["shippingAddress" => $this->shippingAddress])
                      @php($step++)
                  @endif
              </div>

              <div class="col-12 col-md-12 col-lg-4">

                  @if($requireShippingMethod)
                    @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.shipping_methods')
                      @php($step++)
                  @endif

                  @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.payment_methods',["paymentMethod" => $this->paymentMethod])
                  @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.order_summary',[
              "shippingMethod" => $this->shippingMethod, "paymentMethod" => $this->paymentMethod, "total" => $this->total])

              </div>

            </div>

            <div class="row">
              <div class="col py-2">
                <a class="btn btn-success" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
              </div>
            </div>

        @else
          <div class="row">
            <div class="alert alert-primary" role="alert">
              {{ trans('icommerce::checkout.no_products_1') }}
              <a href="{{ url('/') }}" class="alert-link">
                {{ trans('icommerce::checkout.no_products_here') }}
              </a>
              {{ trans('icommerce::checkout.no_products_2') }}
            </div>


          </div>
        @endif
      </div>
    </div>

  </div>
  
  @section("scripts")
    @parent
    <script>
      Livewire.on('orderCreated', orderData => {
        if(orderData.external) {
          window.open(orderData.redirectRoute)
        }else{
          window.location.replace(orderData.url)
        }
      })
    </script>
    @stop
