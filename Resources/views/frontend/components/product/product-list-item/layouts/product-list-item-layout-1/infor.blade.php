<div class="infor">
  
  <a class="title" href="{{$product->url}}">{{$product->name}}</a>
  
  <div class="category">{{$product->category->title}}</div>
  
  @if(isset($productListLayout) && $productListLayout=='one')
    <div class="d-none d-lg-block summary">
      {{$product->summary}}
    </div>
  @endif
  
  
  <div class="row align-items-end">
    @if(!$product->is_call)
      <div class="col col-price">
        <div class="price">
          {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($discount->price ?? $product->price)}}
        </div>
        @if(isset($discount) && $discount)
          <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
        @endif
      </div>
     @else
      <div class="col">
        <a href="{{ URL::to('/contacto') }}" class="btn btn-warning px-4 text-white cursor-pointer">
          {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
        </a>
      </div>
     @endif
      <div class="col-auto col-buttons">
        
        <div class="buttons">
          @if(!$product->is_call && $product->stock_status)
            <a class="add-cart" onClick="window.livewire.emit('addToCart',{{$product->id}})">
              <i class="fa fa-shopping-basket"></i>
            </a>
          @endif
          <a class="wishlist" onClick="window.livewire.emit('addToWishList',{{$product->id}})">
            <i class="fa fa-heart-o"></i>
          </a>
        </div>
      
      </div>
  
  </div>
  @if($addToCartWithQuantity && !$product->is_call)
    @include("icommerce::frontend.components.product.addToCartWithQuantity")
  @endif


</div>

