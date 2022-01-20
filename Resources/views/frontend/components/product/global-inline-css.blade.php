@once
    <style>
    @if($externalShadowOnHover)

          .product-layout:hover {
            box-shadow: 0 0.5rem 1rem {{$externalShadowOnHoverColor}};
          }

    @endif
    @if(!$withTextInAddToCart)

          .product-layout .add-to-cart-with-quantity.rounded .add-to-cart-button a i {
            margin-right: 0px !important;
          }

    @endif
    @if($withTextInAddToCart && $buttonsLayout=="rounded" && $addToCartWithQuantity)

          .product-layout-1 .buttons.rounded a.add-to-cart-with-quantity-button {
            width: unset !important;
            height: unset !important;
            padding: 0.25rem 0.6rem;
            font-size: 0.825rem !important;
            line-height: 1.5 !important;
            @if($addToCartWithQuantityStyle == "square")
              border-radius: opx;
            @endif
          }

    @endif

    </style>
@endonce