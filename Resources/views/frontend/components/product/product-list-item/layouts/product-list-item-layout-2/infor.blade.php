<div class="infor">
  
  <div class="card-product">
    <div class="cursor-pointer position-relative">
      
      @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-2.image')
      
      <div class="card-overlay text-center">
        
        <div class="top">
          <a href="{{ $product->url }}"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-search"></i>
          </a>
          <a onClick="window.livewire.emit('addToWishList',{{$product->id}})"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-heart-o"></i>
          
          </a>
        </div>
        
        <div class="bottom">
          @if($product->price>0 || $product->stock_status == 1)
            <a  onClick="window.livewire.emit('addToCart',{{$product->id}})" class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-shopping-basket"></i>
              COMPRAR
            </a>
          @else
            <a href="/contacto" class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-envelope"></i> CONTACTANOS
            </a>
          @endif
        </div>
      
      </div>
    
    </div>
    
    <div class="mt-3 pb-3">
      
      <a href="{{$product->url}}" class="name cursor-pointer d-block text-uppercase text-center">
        {{$product->name}}
      </a>
      
      <div class="category text-center">{{$product->category->title}}</div>
      
      @if(isset($mainLayout) && $mainLayout=='one')
        <div class="summary">
          {{$product->summary}}
        </div>
      @endif
      
      <div class="price text-center">
        
        {{isset($currency) ? $currency->symbol_left : '$'}}
        {{formatMoney($discount->price ?? $product->price)}}
        
        @if(isset($discount) && $discount)
          <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
        
        @endif
      
      </div>
    
    </div>
  </div>
</div>