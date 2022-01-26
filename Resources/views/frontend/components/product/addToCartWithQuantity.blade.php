@if($product->price>0 && $product->stock_status && $product->quantity)
    <div class="col no-padding">
        <div class="row m-0 add-to-cart-with-quantity {{$buttonsLayout}} align-items-center justify-content-between"
             style="padding-left: {{$addToCartWithQuantityPaddingX}}px; padding-right: {{$addToCartWithQuantityPaddingX}}px;
                     padding-top: {{$addToCartWithQuantityPaddingY}}px; padding-bottom: {{$addToCartWithQuantityPaddingY}}px;
                     margin-bottom: {{$addToCartWithQuantityMarginBottom}}px !important;">
            <!-- BUTTON QUANTITY -->
            <div class="number-input input-group quantity-selector">
                <button wire:click="$emit('decrementValue',$event)" type="button" class="button-minus"
                        data-field="quantity">
                  <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
                <input type="number" step="1" value="1" min="1" name="quantity" class="quantity-field d-inline-block form-control">
                <button wire:click="$emit('incrementValue',$event)" type="button" class="button-plus"
                        data-field="quantity"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <!-- BUTTON ADD -->
            <div class="add-to-cart-button buttons {{$buttonsLayout}} text-xs-center text-md-right">
                <a wire:click="$emit('addCartWithQuantity',$event)"
                   class="btn btn-primary btn-sm add-to-cart-with-quantity-button"
                   data-pid="{{$product->id}}">
                    @if($withIconInAddToCart)
                        <i class="fa {{$addToCartIcon}}"></i>
                    @endif
                    @if($withTextInAddToCart)
                        {{trans("icommerce::products.button.addToCartItemList")}}
                    @endif
                </a>

                @if(!$withTextInAddToCart)
                    <a class="wishlist btn btn-primary btn-sm ml-1"
                       onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})">
                        <i class="fa fa-heart-o"></i>
                    </a>
                @endif

            </div>
            <!-- BUTTON ADD QUOTE -->
            @if(setting("icommerce::showButtonToQuoteInStore"))
                <div class="add-to-cart-quote-button">
                    <a wire:click="$emit('addCartQuoteWithQuantity',$event)"
                       class="btn btn-primary btn-sm add-to-cart-quote-with-quantity-button"
                       data-pid="{{$product->id}}">
                        <i class="fas fa-file-alt"></i>{{trans('icommerce::cart.button.add_to_cart_quote')}}
                    </a>
                </div>
            @endif
        </div>
    </div>
    @once
@section('scripts-owl')
    @parent
    <script type="text/javascript" defer>

      function icommerce_incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
          parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
          parent.find('input[name=' + fieldName + ']').val(0);
        }
      }

      function icommerce_decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
          parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
          parent.find('input[name=' + fieldName + ']').val(1);
        }
      }

      function icommerce_addToCartWithQuantity(e) {
        e.preventDefault();
        let addBtn = $(e.target)
        let divParentAdd = addBtn.closest('div.add-to-cart-with-quantity')
        let quantitySelector = $(divParentAdd).children("div.number-input.input-group.quantity-selector")[0];
        let quantityInput = $(quantitySelector).children("input.quantity-field")[0];
        let productId = $(e.target).data('pid');
        window.livewire.emit('addToCart', productId, $(quantityInput).val())
        $(quantityInput).val(1)
      }

      function icommerce_addToCartQuoteWithQuantity(e) {
        e.preventDefault();
        let addBtn = $(e.target)
        let divParentAdd = addBtn.closest('div.add-to-cart-with-quantity')
        let quantitySelector = $(divParentAdd).children("div.number-input.input-group.quantity-selector")[0];
        let quantityInput = $(quantitySelector).children("input.quantity-field")[0];
        let productId = $(e.target).data('pid');
        window.livewire.emit('addToCart', productId, $(quantityInput).val(), {}, true)
        $(quantityInput).val(1)
      }

      @if(isset($productListLayout) && !empty($productListLayout))
      Livewire.on('incrementValue', (e) => {
        icommerce_incrementValue(e);
      })

      Livewire.on('decrementValue', (e) => {
        icommerce_decrementValue(e);
      })

      Livewire.on('addCartWithQuantity', (e) => {
        icommerce_addToCartWithQuantity(e);
      })
      Livewire.on('addCartQuoteWithQuantity', (e) => {
        icommerce_addToCartQuoteWithQuantity(e);
      })
      @else
      $('.infor .input-group').on('click', '.button-plus', function (e) {
        icommerce_incrementValue(e);
      });
      $('.infor .input-group').on('click', '.button-minus', function (e) {
        icommerce_decrementValue(e);
      });
      $('.infor .add-to-cart-with-quantity-button').click(function (e) {
        icommerce_addToCartWithQuantity(e);
      });
      $('.infor .add-to-cart-quote-with-quantity-button').click(function (e) {
        icommerce_addToCartQuoteWithQuantity(e);
      });
        @endif

    </script>

@stop
@endonce

@endif