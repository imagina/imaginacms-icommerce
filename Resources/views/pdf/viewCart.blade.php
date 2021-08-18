<!-- articulos en el carrito -->
@if($cart->products->count())
  @foreach($cart->products as $cartProduct)

    <div class="item_carting px-3 w-100 row m-0">
      <hr class="mt-0 mb-3 w-100">

      <!-- imagen -->
      <div class="col-3 px-0 mb-3">
        <div class="img-product-cart">
          <x-media::single-image
            :alt="$cartProduct->product->name"
            :title="$cartProduct->product->name"
            :url="$cartProduct->product->url"
            :isMedia="true"
            :mediaFiles="$cartProduct->product->mediaFiles()"/>
        </div>
      </div>

      <!-- descripción -->
      <div class="col-9">

        <!-- titulo -->
        <h6 class="mb-2 w-100 __title">
            {{ $cartProduct->product->name }}
            @if($cartProduct->productOptionValues->count())
              <br>
              @foreach($cartProduct->productOptionValues as $productOptionValue)
                <label>{{$productOptionValue->option->description}}
                  : {{$productOptionValue->optionValue->description}}</label>
              @endforeach
            @endif
          </a>
        </h6>

        <!-- valor y cantidad -->
        <p class="mb-0 text-muted pb-2" style="font-size: 13px">
          {{trans('icommerce::cart.table.quantity')}}: {{ $cartProduct->quantity }} <br>
          {{trans('icommerce::cart.table.price_per_unit')}}: {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
        </p>
      </div>

    </div>
  @endforeach
@endif

<!-- FOOTER CARTING -->
@if($cart->products->count())
  <div class="dropdown-footer text-center">

    <hr class="mt-1 mb-3">
    <!-- total -->
    <h6 class="font-weight-bold">
      {{trans('icommerce::cart.table.total')}}
      <span class="text-primary">
         {{isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney( $cart->total )}} {{isset($currency) ? $currency->symbol_right : ''}}
            </span>
    </h6>
  </div>
@endif