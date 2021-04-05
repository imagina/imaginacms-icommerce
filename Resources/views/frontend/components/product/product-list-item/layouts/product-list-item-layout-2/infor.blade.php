<div class="infor">
  
  <div class="card-product">
    <div class="cursor-pointer position-relative">
      @if(!isset($itemListLayout) || $itemListLayout!='one')
        
        <div class="bg-img bg-img-{{$productAspect}} d-flex justify-content-center align-items-center overflow-hidden">
          <x-media::single-image :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
                                 :mediaFiles="$product->mediaFiles()"/>
        </div>
      
      @endif
      <div class="card-overlay text-center">
        
        <div class="top">
          <a href="{{ $product->url }}"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-search"></i>
          </a>
          
          <a onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-heart-o"></i>
          
          </a>
        </div>
        
        <div class="bottom">
          @if(!$product->is_call && $product->stock_status)
            <a onClick="window.livewire.emit('addToCart',{{$product->id}})"
               class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-shopping-basket"></i>
              COMPRAR
            </a>
          @else
            <a href="/contacto" class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-envelope"></i> {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
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
      
      @if(isset($productListLayout) && $productListLayout=='one')
        <div class="d-none d-md-block summary">
          {{$product->summary}}
        </div>
      @endif
      
      @if(!$product->is_call)
        <div class="price text-center">
          
          {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($discount->price ?? $product->price)}}
          
          @if(isset($discount) && $discount)
            <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
          
          @endif
        
        </div>
      @endif
    </div>
    @if($addToCartWithQuantity && !$product->is_call)
      @include("icommerce::frontend.components.product.addToCartWithQuantity")
    @endif
  </div>
</div>