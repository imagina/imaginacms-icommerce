
  <div class="card-product">
    <div class="cursor-pointer position-relative">
      @if(!isset($itemListLayout) || $itemListLayout!='one')
        
        <div class="bg-img bg-img-{{$imageAspect}} d-flex justify-content-center align-items-center overflow-hidden">
          <x-media::single-image :alt="$product->name" :title="$product->name" :url="$product->url"
                                 :isMedia="true"
                                 :imgStyles="'padding: '.$imagePadding.'px; border: '.($imageBorder ? '1' : '0').'px solid '.$imageBorderColor.'; border-radius: '.$imageBorderRadius.'px;'"
                                 :mediaFiles="$product->mediaFiles()"/>
        </div>
      
      @endif
      <div class="card-overlay text-center">
        @if((($withTextInAddToCart && $addToCartWithQuantity) || !$addToCartWithQuantity)
            && !in_array($buttonsLayout,["aw-together-square", "aw-together-circle"]))
        <div class="top">
          
         
            <a
              onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})"
              class="btn btn-primary btn-sm mx-2">
              <i class="fa fa-heart-o"></i>
            
            </a>
     
        </div>
        @endif
        <div class="bottom buttons {{$buttonsLayout}}">
          
          @if((!$product->is_call || setting("icommerce::canAddIsCallProductsIntoCart")) && $product->stock_status && $product->quantity)
            @switch(setting("icommerce::addToCartButtonAction"))
              @case("add-to-cart")
              @if(!$addToCartWithQuantity)
                <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},false)"
                   class="btn btn-primary btn-sm">
                  @if($withIconInAddToCart)
                    <i class="fa fa-shopping-basket"></i>
                  @endif
                  @if($withTextInAddToCart)
                    {{trans("icommerce::products.button.addToCartItemList")}}
                  @endif
                </a>
              @endif
              @break
              @case("go-to-show-view")
              <a href="{{$product->url}}"
                 class="btn btn-primary btn-sm">
                <i class="fa fa-shopping-basket"></i>
                @if($withTextInAddToCart)
                  {{trans("icommerce::products.button.addToCartItemList")}}
                @endif
              </a>
              @break
            @endswitch
            @switch(setting("icommerce::addToCartQuoteButtonAction"))
              @case("add-to-cart-quote")
              @if(setting("icommerce::showButtonToQuoteInStore"))
                <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},true )"
                   class="btn btn-primary btn-sm">
                  <i class="fa fa-file"></i>
                  {{trans("icommerce::products.button.addToCartItemList")}}
                </a>
              @endif
            @endswitch
  
              @if((($withTextInAddToCart && $addToCartWithQuantity) || !$addToCartWithQuantity) && in_array($buttonsLayout,["aw-together-square", "aw-together-circle"]))
            
                  <a
                    onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-heart-o"></i>
      
                  </a>
                
              @endif
          
          @else
            <a onClick="window.livewire.emit('makeQuote',{{$product->id}})"
               class="btn btn-primary btn-sm">
              <i class="fa fa-envelope"></i> {{$customIndexContactLabel}}
            </a>
          
          @endif
        </div>
      
      </div>
    
    </div>
    
    <div class="infor text-{{$contentAlign}}" style="padding-left: {{$contentExternalPaddingX}}px; padding-right: {{$contentExternalPaddingX}}px;
      padding-top: {{$contentExternalPaddingY}}px; padding-bottom: {{$contentExternalPaddingY}}px;">
      
      <a href="{{$product->url}}" class="name cursor-pointer d-block">
        {{$product->name}}
      </a>
      
      <div class="category">{{$product->category->title}}</div>
      
      @if(isset($productListLayout) && $productListLayout=='one')
        <div class="d-none d-md-block summary">
          {{$product->summary}}
        </div>
      @endif
      
      @if(!$product->is_call)
        <div class="price">
          
          {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($discount->price ?? $product->price)}}
          
          @if(isset($discount) && $discount)
            <del
              class="d-inline-block">{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
          
          @endif
        
        </div>
      @endif
    </div>
    @if($addToCartWithQuantity && !$product->is_call)
      @include("icommerce::frontend.components.product.addToCartWithQuantity")
    @endif
  </div>

