<div class="infor text-{{$contentAlign}}"
     style="padding-left: {{$contentExternalPaddingX}}px; padding-right: {{$contentExternalPaddingX}}px;
       padding-top: {{$contentExternalPaddingY}}px; padding-bottom: {{$contentExternalPaddingY}}px;">
  
  <a class="title" href="{{$product->url}}"
     style="font-size: {{$contentTitleFontSize}}px;
       height: {{$contentTitleMaxHeight}}px; font-weight: {{$contentTitleFontWeight}};
     @if($contentTitleToUppercase)text-transform: uppercase; @endif">
    {!! Str::limit( $product->name, $contentTitleNumberOfCharacters) !!}
  </a>
  @if($contentCategoryEnable && isset($product->category))
    <div class="category"
         style="font-size: {{$contentCategoryFontSize}}px; font-weight: {{$contentCategoryFontWeight}};
         @if($contentCategoryToUppercase)text-transform: uppercase; @endif">{{$product->category->title}}</div>
  @endif

  
  @if(isset($productListLayout) && $productListLayout=='one' || $withDescription)
    <div class="@if(!$withDescription) d-none @endif d-lg-block summary">
      {{$product->summary}}
    </div>
  @endif
  
  <div class="row align-items-center">
    @if(!$product->is_call && $withPrice)
      <div class="col col-price @if(!$withTextInAddToCart || $buttonsPosition!="in-content") w-100 @endif">
        <div class="price"
             style="font-size: {{$contentPriceFontSize}}px;
               font-weight: {{$contentPriceFontWeight}};">
          {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($discount->price ?? $product->price)}}
          @if(isset($discount) && $discount)
            <del
              class="d-inline-block">{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
          @endif
        </div>
      </div>
    @endif
    @if((!$addToCartWithQuantity || $withTextInAddToCart) && !Str::contains($buttonsPosition, 'in-photo') && !Str::contains($buttonsPosition, 'after-content'))
      <div class="col-auto col-buttons" style="position: unset">
        @include("icommerce::frontend.components.product.buttons")
      </div>
    @endif
  </div>
  
  @if((!$addToCartWithQuantity || $withTextInAddToCart) && Str::contains($buttonsPosition, 'after-content'))
    <div class="row buttons-after-content">
      <div class="col col-buttons {{$buttonsPosition}}">
        @include("icommerce::frontend.components.product.buttons")
      </div>
    </div>
  @endif
</div>



@if($addToCartWithQuantity && !$product->is_call)
  @include("icommerce::frontend.components.product.addToCartWithQuantity")
@endif

