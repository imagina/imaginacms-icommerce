<div class="options-section">
  <livewire:icommerce::options
    :product="$product"
    onlyType="color_image"
    wire:key="options-product-{{ $product->id }}"
    :onlyOptions="true"
  />
</div>
<div class="infor text-{{$contentAlign}}" style="padding-left: {{$contentExternalPaddingX}}px; padding-right: {{$contentExternalPaddingX}}px;
  padding-top: {{$contentExternalPaddingY}}px; padding-bottom: {{$contentExternalPaddingY}}px;">
  <div class="category">
    {{$product->category->title}}
  </div>

  <div class="name">
    <a href="{{$product->url}}" class="name cursor-pointer">
      {{$product->name}}
    </a>
  </div>
  @if(isset($productListLayout) && $productListLayout=='one')
    <div class="d-none d-md-block summary">
      {{$product->summary}}
    </div>
  @endif
  @if((!$product->is_call  || $product->show_price_is_call) && $withPrice)
    <div class="price">
      {{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
      @if(isset($discount) && $discount)
        <del class="d-inline-block">
          Antes: {{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
      @endif
    </div>
  @endif
  <div class="buttons {{$buttonsLayout}}">
    @if(!$product->is_call && $product->stock_status && $product->quantity)
      @switch(setting("icommerce::addToCartButtonAction"))
        @case("add-to-cart")
          @if(!$addToCartWithQuantity)
            <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},false)"
               class="cart text-primary cursor-pointer">
              @if($withIconInAddToCart)
                <i class="fa fa-shopping-cart icon"></i>
              @endif
              {{trans('icommerce::cart.button.add_to_cart')}}
            </a>
          @endif
          @break
        @case("go-to-show-view")
          <a href="{{$product->url}}" class="cart text-primary cursor-pointer">
            {{trans('icommerce::cart.button.add_to_cart')}}
          </a>
          @break
      @endswitch
      @switch(setting("icommerce::addToCartQuoteButtonAction"))
        @case("add-to-cart-quote")
          @if(setting("icommerce::showButtonToQuoteInStore"))
            <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},true)"
               class="cart text-primary cursor-pointer">
              Añadir para cotizacion
            </a>
          @endif
      @endswitch
    @else
      <a href="{{ URL::to('/contacto') }}" class="cart text-primary cursor-pointer">
        {{$customIndexContactLabel}}
      </a>
    @endif
  </div>
  <!-- calculation according to the information of weight, volume, quantity, lenght-->
  @include('icommerce::frontend.components.product.calculate-pum')
  <div class="product-details py-2 collapse show" id="collapseExample" style="font-size: 10px;">
    <textarea name="productDetails" rows="4" cols="25" wire:model.defer="details" placeholder="Detalles Del Producto"
              maxlength="100" class="form-control" style="height: 40px; font-size: 10px;"></textarea>
    <div class="d-flex justify-content-end">
        <span class="text-muted small mt-1">
          Maximo de caracteres permitidos: 100
         </span>
    </div>
  </div>
  @if($addToCartWithQuantity && !$product->is_call)
    @include("icommerce::frontend.components.product.addToCartWithQuantity")
  @endif
</div>
