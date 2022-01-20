<div class="infor text-{{$contentAlign}}"
     style="padding-left: {{$contentExternalPaddingX}}px; padding-right: {{$contentExternalPaddingX}}px;
             padding-top: {{$contentExternalPaddingY}}px; padding-bottom: {{$contentExternalPaddingY}}px;">

    <a class="title" href="{{$product->url}}"
       style="font-size: {{$contentTitleFontSize}}px;
               @if($contentTitleToUppercase)text-transform: uppercase; @endif">
        {{$product->name}}
    </a>

    <div class="category"
         style="font-size: {{$contentCategoryFontSize}}px;
         @if($contentCategoryToUppercase)text-transform: uppercase; @endif">{{$product->category->title}}</div>

    @if(isset($productListLayout) && $productListLayout=='one')
        <div class="d-none d-lg-block summary">
            {{$product->summary}}
        </div>
    @endif
  
    <div class="row align-items-center">
        @if(!$product->is_call)
            <div class="col col-price @if(!$withTextInAddToCart || $buttonsPosition!="in-content") w-100 @endif">
                <div class="price"
                     style="font-size: {{$contentPriceFontSize}}px;">
                    {{isset($currency) ? $currency->symbol_left : '$'}}
                    {{formatMoney($discount->price ?? $product->price)}}
                    @if(isset($discount) && $discount)
                        <del class="d-inline-block">{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
                    @endif
                </div>

            </div>
        @else
            <div class="col">
                <a onClick="window.livewire.emit('makeQuote',{{$product->id}})"
                   class="btn btn-warning px-4 text-white cursor-pointer">
                    {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
                </a>
            </div>
        @endif
        @if((!$addToCartWithQuantity || $withTextInAddToCart) && !Str::contains($buttonsPosition, 'in-photo') && !Str::contains($buttonsPosition, 'after-content'))
            <div class="col-auto col-buttons" style="position: unset">
                    @include("icommerce::frontend.components.product.buttons")
            </div>
        @endif
    </div>

</div>

@if((!$addToCartWithQuantity || $withTextInAddToCart) && Str::contains($buttonsPosition, 'after-content'))
    <div class="row buttons-after-content">
        <div class="col col-buttons {{$buttonsPosition}}">
            @include("icommerce::frontend.components.product.buttons")
        </div>
    </div>
@endif

@if($addToCartWithQuantity && !$product->is_call)
    @include("icommerce::frontend.components.product.addToCartWithQuantity")
@endif

