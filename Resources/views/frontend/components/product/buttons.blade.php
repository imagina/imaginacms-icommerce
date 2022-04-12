<div class="buttons {{$buttonsLayout}} {{$buttonsPosition}} {{$withTextInAddToCart ? "with-add-cart-text" : "without-add-cart-text"}}
{{$showButtonsOnMouseHover ? "show-on-mouse-hover" : ""}}">
    @if(!$product->is_call && !$product->is_sold_out)
        @switch(setting("icommerce::addToCartButtonAction"))
            @case("add-to-cart") @default
            @if(!$addToCartWithQuantity)
              <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart"
                               :onclick="'window.livewire.emit('.'addToCart'.','.$product->id.',1,{},false)'"
                               :withIcon="$withIconInAddToCart"
                               :iconClass="'fa '.$addToCartIcon"
                               :withLabel="$withTextInAddToCart"
                               :label="trans('icommerce::products.button.addToCartItemList')"
              />
              
            @endif
            @break
            @case("go-to-show-view")
      
              <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart"
                               :onclick="'window.livewire.emit('.'addToCart'.','.$product->id.',1,{},false)'"
                               :withIcon="$withIconInAddToCart"
                               :iconClass="'fa '.$addToCartIcon"
                               :withLabel="$withTextInAddToCart"
                               :label="trans('icommerce::products.button.addToCartItemList')"
              />
    
            @break
        @endswitch
        @switch(setting("icommerce::addToCartQuoteButtonAction"))
            @case("add-to-cart-quote")
            @if(setting("icommerce::showButtonToQuoteInStore"))
      
              <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart"
                               :withIcon="$withIconInAddToCart"
                               :iconClass="'fa '.$addToCartIcon"
                               :withLabel="$withTextInAddToCart"
                               :label="trans('icommerce::products.button.addToCartItemList')"
              />
            
                <a class="add-cart btn btn-sm btn{{Str::contains($buttonsLayout, 'outline') ? "-outline" : ""}}-primary"
                   onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},true)">
                    @if($withIconInAddToCart)
                        <i class="fa fa-file"></i>
                    @endif
                </a>
            @endif
        @endswitch
    @else
        <a onClick="window.livewire.emit('makeQuote',{{$product->id}})"
           class="contact btn btn{{Str::contains($buttonsLayout, 'outline') ? "-outline" : ""}}-primary btn-sm">
            @if($withIconInAddToCart)
                <i class="fa fa-envelope"></i>
            @endif
            @if($withTextInAddToCart)
                {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
            @endif
        </a>
    @endif
    @if((($withTextInAddToCart && $addToCartWithQuantity) || !$addToCartWithQuantity) && $wishlistEnable)
        <a class="wishlist btn btn-sm btn{{Str::contains($buttonsLayout, 'outline') ? "-outline" : ""}}-primary"
           onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})">
            <i class="fa {{$wishlistIcon}}"></i>
        </a>
    @endif
</div>
      