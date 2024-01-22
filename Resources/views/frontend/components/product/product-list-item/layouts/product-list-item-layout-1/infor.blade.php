<div class="infor text-{{$contentAlign}}">
  <a class="title" href="{{$product->url}}">
    {!! Str::limit( $product->name, $contentTitleNumberOfCharacters) !!}
  </a>
  @if($contentCategoryEnable && isset($product->category))
    <div class="category">
      {{$product->category->title}}
    </div>
  @endif

  @if(isset($productListLayout) && $productListLayout=='one' || $withDescription)
    <div class="@if(!$withDescription) d-none @endif d-lg-block summary">
      {{$product->summary}}
    </div>
  @endif
  
  <div class="row align-items-center">
    @if((!$product->is_call || $product->show_price_is_call) && $withPrice)
      <div class="col col-price @if(!$withTextInAddToCart || $buttonsPosition!="in-content") w-100 @endif">
        <div class="price">
          {{isset($currency) ? $currency->symbol_left : '$'}}
          {{formatMoney($discount->price ?? $product->price)}}
          @if(isset($discount) && $discount)
            <del
              class="d-inline-block">{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
          @endif
        </div>
      </div>
    @endif

    <!-- calculation according to the information of weight, volume, quantity, lenght-->
    @include('icommerce::frontend.components.product.calculate-pum')


    @if((!$addToCartWithQuantity || $withTextInAddToCart) && !Str::contains($buttonsPosition, 'in-photo') && !Str::contains($buttonsPosition, 'after-content'))
      <div class="col-auto col-buttons col-buttons-unset">
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
 
  @include('icommerce::frontend.components.product.btn-delete')

</div>


@if($addToCartWithQuantity && !$product->is_call)
  @include("icommerce::frontend.components.product.addToCartWithQuantity")
@endif

