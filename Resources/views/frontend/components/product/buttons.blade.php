<div class="buttons {{$buttonsLayout}} {{$buttonsPosition}} {{$withTextInAddToCart ? "with-add-cart-text" : "without-add-cart-text"}}
{{$showButtonsOnMouseHover ? "show-on-mouse-hover" : ""}}">
@if(!$product->is_call && !$product->is_sold_out)
  @switch(setting("icommerce::addToCartButtonAction"))
    @case("add-to-cart") @default
    @if(!$addToCartWithQuantity)
      <!-- add-cart btn-sm btn -->
        <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart button-small"
                         :onclick="'window.livewire.emit(\'addToCart\','.$product->id.',1,{},false)'"
                         :withIcon="$withIconInAddToCart"
                         :iconClass="'fa '.$addToCartIcon"
                         :withLabel="$withTextInAddToCart"
                           :label="$labelButtonAddProduct ?? trans('icommerce::products.button.addToCartItemList')"
                         :sizeLabel="$bottomFontSize"
        />
      
      @endif
      @break
      @case("go-to-show-view")
      <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart button-small"
                       :href="$product->url"
                       :withIcon="$withIconInAddToCart"
                       :iconClass="'fa '.$addToCartIcon"
                       :withLabel="$withTextInAddToCart"
                       :label="$labelButtonAddProduct ?? trans('icommerce::products.button.addToCartItemList')"
                       :sizeLabel="$bottomFontSize"
      />
      @break
    @endswitch
    @switch(setting("icommerce::addToCartQuoteButtonAction"))
      @case("add-to-cart-quote")
      @if(setting("icommerce::showButtonToQuoteInStore"))
        <x-isite::button :style="$buttonsLayout" buttonClasses="add-cart button-small"
                         :onclick="'window.livewire.emit(\'addToCart\','.$product->id.',1,{},false)'"
                         :withIcon="$withIconInAddToCart"
                         iconClass="fa fa-file"
                         :withLabel="false"
                         :sizeLabel="$bottomFontSize"
                         label="file"
        />
      @endif
    @endswitch
  @else
    
    @php $contactUrl=setting('icommerce::customIndexContactLabel', null, 'Contáctenos'); @endphp
    <x-isite::button :style="$buttonsLayout" buttonClasses="contact button-small"
                     :withIcon="$withIconInAddToCart"
                     :onclick="'window.livewire.emit(\'makeQuote\','.$product->id.')'"
                     iconClass="fa fa-envelope"
                     :withLabel="$withTextInAddToCart"
                     :label="$contactUrl"
                     :sizeLabel="$bottomFontSize"
    />
  @endif
  @if((($withTextInAddToCart && $addToCartWithQuantity) || !$addToCartWithQuantity) && $wishlistEnable)
    
    @php $wishUrl=json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id]); @endphp
    <x-isite::button :style="$buttonsLayout" buttonClasses="wishlist button-small"
                     :onclick="'window.livewire.emit(\'addToWishList\','.$wishUrl.')'"
                     :withIcon="$withIconInAddToCart"
                     :iconClass="'fa '.$wishlistIcon"
                     :withLabel="false"
                     :sizeLabel="$bottomFontSize"
                     :label="trans('icommerce::products.button.wishList')"

    />
  @endif
</div>