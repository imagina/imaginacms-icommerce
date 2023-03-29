<!-- FOOTER CARTING -->
<div class="cart-total m-0">
  @if($cart->products->count())
      <ul class="list-group w-100 rounded-0">
        <li class="list-group-item bg-light font-weight-bold d-flex justify-content-between">
          <span class="text-dark">{{trans('icommerce::cart.table.total')}}</span>
          <span class="text-primary">
                    {{isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney( $cart->products->sum('total') )}} {{isset($currency) ? $currency->symbol_right : ''}}
                </span>
        </li>
        @if($notContainIsCall)
          <li class="list-group-item bg-light">
            <a href="{{ \URL::route(locale() . '.icommerce.store.checkout') }}"
               class="btn btn-warning btn-block text-white">
              {{trans('icommerce::cart.button.view_cart')}}
            </a>
          </li>
        @endif
        @if(setting("icommerce::showButtonThatGeneratesPdfOfTheCart"))
          <li class="list-group-item bg-light">
            <a onClick="window.livewire.emit('download',{{$customer=null}})"
               class="btn btn-warning btn-block text-white">
              {{trans('icommerce::cart.button.download_pdf')}}
            </a>
          </li>
        @endif
        @if($containIsCall)
          <li class="list-group-item bg-light">
            <a onClick="window.livewire.emit('requestQuote')"
               class="btn btn-warning btn-block text-white">
              {{trans('icommerce::cart.button.request_quote')}}
            </a>
          </li>
        @endif

      </ul>
  @endif
</div>
