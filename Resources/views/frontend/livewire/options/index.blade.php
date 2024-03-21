<div>
  <div id="recursiveListOptionsComponent">

    @foreach($options as $index => $productOption)
      @if(!empty($productOption) and is_null($productOption->parent_id))
        <div>
          <div class="content-option">
            @include("icommerce::frontend.livewire.options.partials.option-item",["productOption" => $productOption,"options" => $options])
          </div>
        </div>
      @endif
    @endforeach

  </div>
  @if(!$product->is_call || ($product->is_call && $product->show_price_is_call))

    <div class="price ">
      <div class="mb-0">
      <span class="text-primary font-weight-bold">
        {{isset($currency->id) ? $currency->symbol_left : '$'}}
        {{formatMoney($dynamicPrice = ($product->discount->price ?? $product->price) +$this->priceOptions )}}
        {{isset($currency->id) ? $currency->symbol_right : ''}}
      </span>
        @if(isset($product->discount->price))
          <br><span class="price-desc h6 pl-3">{{ trans('icommerce::products.alerts.beforeDiscount') }} <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del></span>
        @endif
      </div>
    </div>
  @endif
  
<!-- calculation according to the information of weight, volume, quantity, lenght-->
  @include('icommerce::frontend.components.product.calculate-pum',['dynamicPrice' => $dynamicPrice])

  @if(!$product->is_call)
    <div class="add-cart">
      <hr>
      <div class="row">
        <div class="col-12">
          {{$product->quantity}} {{trans("icommerce::products.form.available")}}
        </div>

        <!-- BUTTON QUANTITY -->
        <div class="d-inline-flex align-items-center p-1">
          <div class="input-group ">
            <div class="input-group-prepend">
              <button class="btn btn-outline-light font-weight-bold " field="quantity" type="button"
                      onclick="icommerce_showSetQuantity(event,'-')">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </button>
            </div>
            <input type="text" class="form-control text-center quantity"
                   name="quantityProduct" wire:model.defer="quantity">
            <div class="input-group-append">
              <button class="btn btn-outline-light font-weight-bold" field="quantity" type="button"
                      onclick="icommerce_showSetQuantity(event,'+')">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="d-inline-flex align-items-center p-1">
          <!-- BUTTON ADD -->
          @if(setting('icommerce::warehouseFunctionality', null, false))
            <div wire:ignore>
              @php
                if (setting("icommerce::canAddIsCallProductsIntoCart") && $product->is_call) {
                  $label = trans('icommerce::cart.button.addToCartForQuote');
                } else {
                  $label = trans('icommerce::cart.button.add_to_cart');
                }
              @endphp
              <livewire:icommerce::addToCartButton
                lazy
                :wire:key="(uniqid('addToCartButton-'.$product->id))"
                onclick="icommerce_showAddToCartWithOptions()"
                buttonClasses="btn-comprar btn btn-primary text-white"
                :withIcon=true
                :iconClass="'fa '.@setting('icommerce::productAddToCartIcon', null, 'fa-shopping-cart')"
                :withLabel=true
                :label=$label
                :product=$product
              />
            </div>
          @else
            <div>
              <a onclick="icommerce_showAddToCartWithOptions()" href="#" class="btn-comprar btn btn-primary text-white">
                <i class="fa @setting('icommerce::productAddToCartIcon', null, 'fa-shopping-cart')"></i>
                @if(setting("icommerce::canAddIsCallProductsIntoCart") && $product->is_call)
                  {{trans('icommerce::cart.button.addToCartForQuote')}}
                @else
                  {{trans('icommerce::cart.button.add_to_cart')}}
                @endif
              </a>
            </div>
          @endif

        </div>
        
        @if((boolean)setting('wishlistable::wishlistActive',null,false))
          <div class="d-inline-flex align-items-center p-1">
            <!-- BUTTON WISHLIST -->
            <a
              onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id,"fromBtnAddWishlist"=>true])}})"
              class="btn btn-wishlist mx-2">
              <span>{{ trans('wishlistable::wishlistables.button.addToList') }}</span>
              <i class="fa fa-heart-o ml-1"></i>
            </a>
          </div>
        @endif

      </div>
      <hr>
    </div>
@endif
<!-- PRICE -->

</div>
@section('scripts-owl')
  @parent
  <script type="text/javascript" defer>
    function icommerce_showAddToCartWithOptions(e) {
      window.livewire.emit('addToCartOptions', {quantity: $('input[name=quantityProduct]').val()})
    }

    function icommerce_showSetQuantity(e, type) {
      e.preventDefault();
      var parent = $(e.target).closest('div.input-group');
      var currentVal = parseInt(parent.find('input[name=quantityProduct]').val(), 10);
      console.warn(currentVal)

      if (!isNaN(currentVal)) {
        parent.find('input[name=quantityProduct]').val(type == '-' ? currentVal - 1 : currentVal + 1);
      } else {
        parent.find('input[name=quantityProduct]').val(0);
      }
    }
  </script>
@stop
