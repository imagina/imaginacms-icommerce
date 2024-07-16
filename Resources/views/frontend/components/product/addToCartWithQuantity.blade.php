@if($product->price>0 && $product->stock_status && $product->quantity)
    <div class="col no-padding">
        <div class="row m-0 add-to-cart-with-quantity {{$buttonsLayout}} align-items-center justify-content-between"
             style="padding-left: {{$addToCartWithQuantityPaddingX}}px; padding-right: {{$addToCartWithQuantityPaddingX}}px;
                     padding-top: {{$addToCartWithQuantityPaddingY}}px; padding-bottom: {{$addToCartWithQuantityPaddingY}}px;
                     margin-bottom: {{$addToCartWithQuantityMarginBottom}}px !important;">
            <!-- BUTTON QUANTITY -->
            <div class="number-input input-group quantity-selector">
                <button onclick="icommerce_quantityAction(event)" type="button" class="button-minus"
                        data-action="decrement" aria-label="minus">
                  <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
                <input aria-label="quantity" type="number" step="1" value="1" min="1" name="quantity" class="quantity-field d-inline-block form-control">
                <button onclick="icommerce_quantityAction(event)" type="button" class="button-plus"
                        data-action="increment" aria-label="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <!-- BUTTON ADD  -->
            <div class="add-to-cart-button buttons {{$buttonsLayout}} {{$buttonsPosition}} {{$withTextInAddToCart ? "with-add-cart-text" : "without-add-cart-text"}} text-xs-center text-md-right">
               
                <x-isite::button :style="$buttonsLayout" buttonClasses="button-small add-cart add-to-cart-with-quantity-button"
                                 onclick="icommerce_addToCartWithQuantity(event)"
                                 :withIcon="$withIconInAddToCart"
                                 :iconClass="'fa '.$addToCartIcon"
                                 :withLabel="$withTextInAddToCart"
                                 :label="trans('icommerce::products.button.addToCartItemList')"
                                 :sizeLabel="$bottomFontSize"
                                 :dataItemId="$product->id"
                />

                @if(!$withTextInAddToCart && $wishlistEnable)
                   
                    @php $wishUrlLE = json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id]); @endphp
                    <x-isite::button :style="$buttonsLayout" buttonClasses="wishlist button-small"
                                     :onclick="'window.livewire.emit(\'addToWishList\','.$wishUrlLE.')'"
                                     :withIcon="$withIconInAddToCart"
                                     iconClass="fa fa-heart-o"
                                     :withLabel="false"
                                     sizeLabel="$bottomFontSize"
                                     :label="trans('icommerce::products.button.wishList')"
                    />

                @endif

            </div>
            <!-- BUTTON ADD QUOTE -->
            @if(setting("icommerce::showButtonToQuoteInStore"))
                <div class="add-to-cart-quote-button">
                 
                    <x-isite::button :style="$buttonsLayout" buttonClasses="button-small add-to-cart-quote-with-quantity-button"
                                     onclick="icommerce_addToCartQuoteWithQuantity(event)"
                                     :withIcon="true"
                                     iconClass="fas fa-file-alt"
                                     :withLabel="true"
                                     :label="trans('icommerce::cart.button.add_to_cart_quote')"
                                     :sizeLabel="$bottomFontSize"
                                     :dataItemId="$product->id"
                    />

                </div>
            @endif
        </div>
    </div>
    @once
@section('scripts-owl')
    @parent
    <script type="text/javascript" defer>

      function icommerce_quantityAction(e) {
      
        e.preventDefault();
        var action = $(e.target).data('action');
        var parent = $(e.target).closest('div');
        var quantityInput = parent.find('input[name=quantity]');
        var currentVal = parseInt(quantityInput.val(), 10);
        
        if (!isNaN(currentVal)) quantityInput.val(1);
          if(action == "increment")
            quantityInput.val(currentVal + 1);
          else{
            quantityInput.val(currentVal - 1);
          }
      }

      function icommerce_addToCartWithQuantity(e) {
        e.preventDefault();
        let addBtn = $(e.target)
        let divParentAdd = addBtn.closest('div.add-to-cart-with-quantity')
        let quantitySelector = $(divParentAdd).children("div.number-input.input-group.quantity-selector")[0];
        let quantityInput = $(quantitySelector).children("input.quantity-field")[0];
        let productId = $(e.target).data('item-id');
        window.livewire.emit('addToCart', productId, $(quantityInput).val())
        $(quantityInput).val(1)
      }

      function icommerce_addToCartQuoteWithQuantity(e) {
        e.preventDefault();
        let addBtn = $(e.target)
        let divParentAdd = addBtn.closest('div.add-to-cart-with-quantity')
        let quantitySelector = $(divParentAdd).children("div.number-input.input-group.quantity-selector")[0];
        let quantityInput = $(quantitySelector).children("input.quantity-field")[0];
        let productId = $(e.target).data('item-id');
        window.livewire.emit('addToCart', productId, $(quantityInput).val(), {}, true)
        $(quantityInput).val(1)
      }

    </script>

@stop
@endonce

@endif