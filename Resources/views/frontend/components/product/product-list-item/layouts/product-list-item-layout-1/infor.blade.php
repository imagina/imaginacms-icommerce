<div class="infor">
  
  <a class="title" href="{{$product->url}}">{{$product->name}}</a>
  
  <div class="category">{{$product->category->title}}</div>
  
  @if(isset($productListLayout) && $productListLayout=='one')
    <div class="summary">
      {{$product->summary}}
    </div>
  @endif
  
  
  @if(isset($discount) && $discount)
    <div class="del-price">
      <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
    </div>
  @endif
  
  
  <div class="row align-items-end">
    <div class="col col-price">
      <div class="price">
        {{isset($currency) ? $currency->symbol_left : '$'}}
        {{formatMoney($discount->price ?? $product->price)}}
      </div>
    </div>
    
    <div class="col-auto col-buttons">
      
      <div class="buttons">
        @if($product->price>0  && $product->stock_status && $product->quantity)
          <a class="add-cart" onClick="window.livewire.emit('addToCart',{{$product->id}})">
            <i class="fa fa-shopping-basket"></i>
          </a>
        @endif
        <a class="wishlist" onClick="window.livewire.emit('addToWishList',{{$product->id}})" >
          <i class="fa fa-heart-o"></i>
        </a>
      </div>
    
    </div>
  
  </div>
  @if($addToCartWithQuantity)
   @include("icommerce::frontend.components.product.addToCartWithQuantity")
  @endif


</div>

