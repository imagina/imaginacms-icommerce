@php
  $currencyGtag = $currency->code ?? 'COP';
  $paymentMethodsGtag = json_encode($paymentMethods->pluck('title')->toArray());
  //map product to gtag
  $productsGtag = $cart->products->map(function($carProduct, $index) {
    // Calculate price using the discount if available, otherwise use the base price
    $price = $carProduct->product->discount->price ?? $carProduct->product->price;
    return [
      'index' => $index,
      'item_id' => $carProduct->product->id,
      'item_name' => $carProduct->product->name,
      'price' => $price,
      'currency' =>  "COP",
      'quantity' => $carProduct->quantity
    ];
  })
@endphp

<div id="cardOrderSummary" class="card card-block order p-3">
  <div class="row">
    <div class="col">
      <div class="row m-0 pointer card-number-text" data-toggle="collapse" href="#CheckList" role="button"
           aria-expanded="false"
           aria-controls="CheckList">
        <div class="number-check">
          <i class="fa fa-check px-1"></i>
        </div>
        <h3 class="d-flex align-items-center my-1 h5">
          {{ trans('icommerce::order_summary.title') }}
        </h3>
      </div>
      <div id="CheckList" class="collapse show">
        <hr class="my-2"/>
        <div class="row">
          <div class="col">
            <h5 class="dropdown-header mb-0">
              {{$cart->products->count()}}
              @if($cart->products->count()>1)
                <span>{{ trans('icommerce::order_summary.items_car') }}</span>
              @else
                <span>{{ trans('icommerce::order_summary.item_car') }}</span>
              @endif
            </h5>
            {{-- <hr class="mt-0 mb-3"/> --}}
            <div class="box-items-cart">
              <!-- CART | ITEMS -->
              @if($cart->products->count())
                @foreach($cart->products as $cartProduct)
                  <div class="item_carting px-3 w-100 row m-0">
                    <hr class="mt-0 mb-3 w-100">
                    @php($mediaFiles = $cartProduct->product->mediaFiles())
                    @php($withImage = !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
                    @if($withImage)
                      <!-- imagen -->
                      <div class="col-3 px-0 mb-3">
                        <div class="img-product-cart">
                          <x-media::single-image
                            :alt="$cartProduct->product->name"
                            :title="$cartProduct->product->name"
                            :url="$cartProduct->product->url"
                            :isMedia="true"
                            imgClasses="img-fluid"
                            :mediaFiles="$cartProduct->product->mediaFiles()"/>
                        </div>
                      </div>
                    @endif
                    <!-- descripción -->
                    <div class="{{$withImage ? 'col-9' : 'col-12'}}">
                      <!-- titulo -->
                      <h6 class="mb-2 w-100 __title">
                        <a class="product-title" href="{{$cartProduct->product->url}}">
                          {{ $cartProduct->product->name }}
                          @include("icommerce::frontend.livewire.cart.productOptions")
                        </a>
                      </h6>
                      <!-- valor y cantidad -->
                      <div class="input-group quantity-selector quantity-selector-checkout py-2">
                        <button type="button" class="button-minus" onclick="decreaseQuantity(this)" aria-label="minus">
                          <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>

                        <input type="number" step="1" min="1" max="{{$cartProduct->product->quantity}}"
                               class="quantity-field form-control" value="{{$cartProduct->quantity}}"
                               oninput="if(this.value == '') this.value = 1"
                               onchange="debouncedLivewireEmit(this, {{ $cartProduct->id }}, {{ $cartProduct->product->quantity }})">

                        <button type="button" class="button-plus" onclick="increaseQuantity(this)" aria-label="plus">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                      <p class="text-quantity mb-0 text-muted py-2">
                        {{-- {{trans('icommerce::cart.table.quantity')}} : {{ $cartProduct->quantity }} <br> --}}
                        {{trans('icommerce::cart.table.price_per_unit')}}
                        : {{isset($currency) ? $currency->symbol_left : '$'}}
                        {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
                      </p>
                      @if($cartProduct->product->shipping)
                        <p>
                          <small>
                            <i class="fa fa-truck"
                               aria-hidden="true"></i> {{trans("icommerce::products.table.shipping")}}
                          </small>
                        </p>
                      @endif
                      <!-- boton para eliminar y detalles del producto-->
                      <div class="button-remove d-flex align-items-center justify-content-end">
                        @if(isset($cartProduct->details) && !empty($cartProduct->details))
                          <div class="product-details mx-2" data-toggle="tooltip" data-placement="top"
                               title="{{ $cartProduct->details }}">
                            <i class="fa-solid fa-circle-info text-primary"></i>
                          </div>
                        @endif
                        <a class="close cart-remove text-danger"
                           onclick="window.livewire.emit('deleteFromCart',{{$cartProduct->id}})"
                           title="quitar producto">
                          <i class="fa fa-times"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <hr class="mt-1 mb-2"/>
            <div class="dropdown-footer col-12">
              <!-- CART | SUB TOTAL -->
              <div class="row">
                <div class="col-4">
                  <div class="my-2">{{ trans('icommerce::order_summary.car_sub') }}</div>
                </div>
                <div class="col-8 text-right">
                  <div class="my-2">
                    {{isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney( $cart->total )}} {{isset($currency) ? $currency->symbol_right : ''}}
                  </div>
                </div>
              </div>
              <!--  COUPON | CODE AND AMOUNT -->
              @if(isset($couponSelected->id))
                <div class="row">
                  <div class="col-4">
                    <div class="my-2">{{ trans('icommerce::order_summary.coupon') }}</div>
                  </div>
                  <div class="col-8 text-right">
                    <div class="my-2">
                      {{ trans('icommerce::order_summary.couponCode') }}
                      {{$couponSelected->code }}
                      <br>
                      {{ isset($currency) ? $currency->symbol_left : '$'}} {{ "(".formatMoney($couponDiscount->discount).")" }} {{isset($currency) ? $currency->symbol_right : ''}}
                    </div>
                  </div>
                </div>
              @endif
              @if(!empty($totalTaxes))
                <!--  TAXES  -->
                <div class="row">
                  <div class="col-12">
                    <div class="my-2">{{ trans('icommerce::order_summary.taxes') }}</div>
                  </div>
                  @foreach($totalTaxes as $totalTax)
                    <div class="col-5">
                      <div>{{ $totalTax["rateName"] ."  (".$totalTax['rate'].")"  }}</div>
                    </div>
                    <div class="col-7 text-right">
                      {{ isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($totalTax["totalTax"])}}{{isset($currency) ? $currency->symbol_right : ''}}
                    </div>
                  @endforeach
                </div>
              @endif
              @if($requireShippingMethod)
                <!--  SHIPPING METHOD | TITLE AND AMOUNT -->
                <div class="row">
                  <div class="col-4">
                    <div class="my-2">{{ trans('icommerce::order_summary.shipping') }}</div>
                  </div>
                  <div class="col-8 text-right">
                    @if(!isset($shippingMethod->id))
                      <div class="my-2">
                        {{ trans('icommerce::order_summary.shipping_not_selected')}}
                      </div>
                    @else
                      <div class="my-2">
                        {{$shippingMethod->title }}
                        <br>
                        @if(isset($shippingMethod->calculations->priceshow) && $shippingMethod->calculations->priceshow)
                          {{ isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney($shippingMethod->calculations->price) }} {{isset($currency) ? $currency->symbol_right : ''}}
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
              @endif
            </div>
            <hr class="mt-0 mb-1"/>
            <div class="dropdown-footer">
              <div class="card border-0">
                <div class="card-header bg-white" id="couponHeadline">
                  <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse"
                            data-target="#couponCollapse" aria-expanded="true"
                            aria-controls="couponHeadline">
                      {{ trans('icommerce::coupons.title.addCoupon') }}
                    </button>
                  </h5>
                </div>
                <div class="card-body">
                  <div id="couponCollapse" class="collapse w-100" aria-labelledby="couponHeadline">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <input id="couponCode" placeholder="{{trans("icommerce::coupons.title.typeCoupon")}}"
                                 class="form-control" type="text"/>
                        </div>
                        <div class="form-group text-center">
                          <button class="btn btn-sm btn-outline-primary w-100"
                                  wire:click="validateCoupon(document.getElementById('couponCode').value)">
                            {{ trans('icommerce::coupons.title.aplyCoupon') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <h6>
                    {{ trans('icommerce::order_summary.total') }}
                  </h6>
                </div>
                <div class="col-8">
                  <h5 class="font-weight-bold text-right">
                    {{ isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney($total) }} {{isset($currency) ? $currency->symbol_right : ''}}
                  </h5>
                </div>
              </div>

              <!--  PAYMENT METHOD | TITLE AND DESCRIPTION -->
              <div class="row">
                <div class="col-4">
                  <div>{{ trans('icommerce::order_summary.payment') }}</div>
                </div>
                <div class="col-8 text-right">
                  <p id="orderSummaryPaymentMethodTitleContainer">
                    {{$paymentMethod->title ?? trans("icommerce::paymentmethods.messages.noPaymentMethodSelected") }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="from-group">
              <label for="comment">
                {{trans('icommerce::checkout.comment')}}
              </label>
              <textarea class="form-control"
                        placeholder="{{trans('icommerce::checkout.commentPlaceholder')}}"
                        id="comment"
                        wire:model.defer="comment"></textarea>

            </div>
          </div>
        </div>
        @if((Setting::has('icommerce::orderSummaryDescription')))
          <div class="order-summary-description py-2">
            <x-isite::edit-link
              link="/iadmin/#/site/settings?settings=orderSummaryDescription&module=icommerce"
            />
            {!! setting('icommerce::orderSummaryDescription') !!}
          </div>
        @endif
        <div class="mt-3">
          <button type="button" class="btn btn-link p-0 w-100 text-right"
                  href="{{url('/')}}">
            <div>
              {{ trans('icommerce::checkout.continue_buying') }}
            </div>
          </button>
          <button type="button" class="btn btn-warning btn-lg w-100 mt-3 placeOrder"
                  onclick="orderSumamryPlaceOrder()">
            <div>
              {{ trans('icommerce::order_summary.submit') }}
            </div>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" defer>
  function orderSumamryPlaceOrder() {
    gTagFireEventPurchase()
    // Trigger the Livewire action
    window.livewire.emit("{{config("asgard.icommerce.config.livewirePlaceOrderClick")}}")
  }

  function gTagFireEventPurchase() {
    // Check if gtag function is available
    if (typeof gtag !== "function") return;

    //Validate paymentMethodSelected
    const paymentMethod = document.getElementById('orderSummaryPaymentMethodTitleContainer').innerText
    const paymentMethods = {!! $paymentMethodsGtag !!};

    if (paymentMethods.includes(paymentMethod)) {
      //Instance the main data
      let gTagData = {
        transaction_id: {{$cart->id}},
        value: {{$total}},
        currency: "{{$currencyGtag}}",
        payment_type: paymentMethod,
        items: {!! $productsGtag !!}
      }

      //Emit gtag event
      gtag("event", "purchase", gTagData);
    }
  }

  let debounceTimeout;

  function debouncedLivewireEmit(input, productId, maxQuantity) {
    clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(() => {
      let value = parseInt(input.value) || 1;

      if (value < 1) {
        value = 1;
      } else if (value > maxQuantity) {
        value = maxQuantity;
      }

      input.value = value;

      // Emitir evento a Livewire
      Livewire.emit('updateQuantityCartProduct', productId, value);
    }, 500); // Debounce de 500ms
  }

  window.decreaseQuantity = function(button) {
    let input = button.closest('.input-group').querySelector('.quantity-field');
    let min = parseInt(input.min);
    let value = parseInt(input.value) || 1;

    if (value > min) {
      input.value = value - 1;
      input.dispatchEvent(new Event('change')); // Disparar onchange con debounce
    }
  };

  window.increaseQuantity = function(button) {
    let input = button.closest('.input-group').querySelector('.quantity-field');
    let max = parseInt(input.max);
    let value = parseInt(input.value) || 1;

    if (value < max) {
      input.value = value + 1;
      input.dispatchEvent(new Event('change'));
    }
  };


</script>
