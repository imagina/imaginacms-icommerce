@once
<style>
.button-minus i, .button-plus i{
    pointer-events: none;
}
.product-layout .add-to-cart-with-quantity .quantity-selector input[type=number]::-webkit-outer-spin-button,
.product-layout .add-to-cart-with-quantity .quantity-selector input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.product-layout .add-to-cart-with-quantity .quantity-selector input[type=number] {
    -moz-appearance:textfield !important;
}

@if($externalShadowOnHover)
.product-layout:hover {
    box-shadow: 0 0.5rem 1rem {{$externalShadowOnHoverColor}};
}
@endif

@if(!$withTextInAddToCart)
.product-layout .add-to-cart-with-quantity.rounded .add-to-cart-button a i,
.product-layout .add-to-cart-with-quantity.rounded .add-to-cart-button button i {
    margin-right: 0px !important;
}
@endif

@if($withTextInAddToCart && $buttonsLayout=="rounded" && $addToCartWithQuantity)
.product-layout-1 .buttons.rounded a.add-to-cart-with-quantity-button,
.product-layout-1 .buttons.rounded button.add-to-cart-with-quantity-button {
    width: unset !important;
    height: unset !important;
    /*padding: 0.25rem 0.6rem;
    font-size: 0.825rem !important;
    line-height: 1.5 !important;*/
    @if($addToCartWithQuantityStyle == "square")
    border-radius: opx;
    @endif
}
@endif

@if($productLayout=='product-list-item-layout-1')
.product-layout-1 {
    padding: {{$externalPadding}}px;
    background-color: {{$productBackgroundColor}};
    border-radius: {{$externalBorderRadius}}px;
    border: {{$externalBorder ? '1' : '0'}}px solid {{$externalBorderColor}};
}
.product-layout-1 .infor {
    padding-left: {{$contentExternalPaddingX}}px;
    padding-right: {{$contentExternalPaddingX}}px;
    padding-top: {{$contentExternalPaddingY}}px;
    padding-bottom: {{$contentExternalPaddingY}}px;">
}
.product-layout-1 .title {
    font-size: {{$contentTitleFontSize}}px;
    height: {{$contentTitleMaxHeight}}px;
    font-weight: {{$contentTitleFontWeight}};
    @if($contentTitleToUppercase) text-transform: uppercase;@endif
}
.product-layout-1 .category {
    font-size: {{$contentCategoryFontSize}}px;
    font-weight: {{$contentCategoryFontWeight}};
    @if($contentCategoryToUppercase)text-transform: uppercase; @endif
}
.product-layout-1 .price {
    font-size: {{$contentPriceFontSize}}px;
    font-weight: {{$contentPriceFontWeight}};
}
.product-layout-1 .col-buttons-unset {
    position: unset;
}
.product-layout-1 .product-img {
    padding: {{$imagePadding}}px;
    border: {{$imageBorder ? '1' : '0'}}px solid {{$imageBorderColor}};
    border-radius: {{$imageBorderRadius}}px;
    -o-object-fit: {{$imageObjectFit}} !important;
    object-fit: {{$imageObjectFit}} !important;
}
@endif
</style>
@endonce