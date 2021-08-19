<div class="infor text-center">

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

  @if(!$product->is_call)
    @if(isset($discount) && $discount)
      <div class="price">
        <i class="fa fa-shopping-cart icon"></i>
        {{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
      </div>
      <div class="cart-no">
        <del>Antes: {{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
      </div>
    @else
      <div class="price">
        <i class="fa fa-shopping-cart icon"></i>
        {{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
      </div>
      <div class="cart-no">&nbsp;</div>
    @endif
  @endif

  @if(!$product->is_call && $product->stock_status)
    @switch(setting("icommerce::addToCartButtonAction"))
      @case("add-to-cart")
      <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},false)"
         class="cart text-primary cursor-pointer">
        Añadir al carrito
      </a>
      @break
      @case("go-to-show-view")
      <a href="{{$product->url}}" class="cart text-primary cursor-pointer">
        Añadir al carrito
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
      {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
    </a>
  @endif



  @if($addToCartWithQuantity && !$product->is_call)
    @include("icommerce::frontend.components.product.addToCartWithQuantity")
  @endif

</div>
