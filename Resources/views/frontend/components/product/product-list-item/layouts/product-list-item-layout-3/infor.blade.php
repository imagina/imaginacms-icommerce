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
    <a onClick="window.livewire.emit('addToCart',{{$product->id}})" class="cart text-primary cursor-pointer">
      Añadir al carrito
    </a>
  @else
    <a href="{{ URL::to('/contacto') }}" class="cart text-primary cursor-pointer">
      Contacta con nosotros
    </a>
  @endif
  
  
  
  @if($addToCartWithQuantity && !$product->is_call)
    @include("icommerce::frontend.components.product.addToCartWithQuantity")
  @endif

</div>
