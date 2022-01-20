<div class="infor text-{{$contentAlign}}" style="padding-left: {{$contentExternalPaddingX}}px; padding-right: {{$contentExternalPaddingX}}px;
  padding-top: {{$contentExternalPaddingY}}px; padding-bottom: {{$contentExternalPaddingY}}px;">

    <div class="category">
        {{$product->category->title}}
    </div>

    <div class="name">
        <a href="{{$product->url}}" class="name cursor-pointer">
            {{$product->name}}
        </a>
    </div>


    @if(isset($productListLayout) && $productListLayout=='one')
        <div class="d-none d-md-block summary">
            {{$product->summary}}
        </div>
    @endif

    @if(!$product->is_call)
        <div class="price">
            {{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
            @if(isset($discount) && $discount)
                <del class="d-inline-block">Antes: {{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
            @endif
        </div>
       
    @endif

    <div class="buttons {{$buttonsLayout}}">
        @if(!$product->is_call && $product->stock_status && $product->quantity)
            @switch(setting("icommerce::addToCartButtonAction"))
                @case("add-to-cart")
                @if(!$addToCartWithQuantity)
                    <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},false)"
                       class="cart text-primary cursor-pointer">
                        @if($withIconInAddToCart)
                            <i class="fa fa-shopping-cart icon"></i>
                        @endif
                        {{trans('icommerce::cart.button.add_to_cart')}}
                    </a>
                @endif
                @break
                @case("go-to-show-view")
                <a href="{{$product->url}}" class="cart text-primary cursor-pointer">
                    {{trans('icommerce::cart.button.add_to_cart')}}
                </a>
                @break
            @endswitch
            @switch(setting("icommerce::addToCartQuoteButtonAction"))
                @case("add-to-cart-quote")
                @if(setting("icommerce::showButtonToQuoteInStore"))
                    <a onClick="window.livewire.emit('addToCart',{{$product->id}},1,{},true)"
                       class="cart text-primary cursor-pointer">
                        Añadir para cotizacion
                    </a>
                @endif
            @endswitch
    
        @else
            <a href="{{ URL::to('/contacto') }}" class="cart text-primary cursor-pointer">
                {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}
            </a>
        @endif
    </div>
  



    @if($addToCartWithQuantity && !$product->is_call)
        @include("icommerce::frontend.components.product.addToCartWithQuantity")
    @endif

</div>
