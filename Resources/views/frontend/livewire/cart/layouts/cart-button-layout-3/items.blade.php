<!-- articulos en el carrito -->
<div class="cart-items h-100">
    @if($cart->products->count())
        @foreach($cart->products as $cartProduct)

            <div class="item_carting border-bottom pt-4">
                <div class="row item_carting">
                    <div class="col-3 pr-0 pb-2">
                        <div class="img-product-cart">
                            <x-media::single-image
                                    :alt="$cartProduct->product->name"
                                    :title="$cartProduct->product->name"
                                    :url="$cartProduct->product->url"
                                    :isMedia="true"
                                    :mediaFiles="$cartProduct->product->mediaFiles()"/>
                        </div>
                    </div>
                    <div class="col pr-0">
                        <!-- titulo -->
                        <h6 class="mb-1 __title">
                            <a href="{{$cartProduct->product->url}}" class="text-dark">
                                {{ $cartProduct->product->name }}
                                @if($cartProduct->productOptionValues->count())
                                    <br>
                                    @foreach($cartProduct->productOptionValues as $productOptionValue)
                                        <label>{{$productOptionValue->option->description}}
                                            : {{$productOptionValue->optionValue->description}}</label>
                                    @endforeach
                                @endif
                            </a>
                        </h6>
                        <!-- valor y cantidad -->
                        <p class="mb-0 text-muted pb-2" style="font-size: 13px">
                            {{trans('icommerce::cart.table.quantity')}}: {{ $cartProduct->quantity }} <br>
                            {{trans('icommerce::cart.table.price_per_unit')}}
                            : {{isset($currency) ? $currency->symbol_left : '$'}}
                            {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
                        </p>
                    </div>
                    <div class="col-auto">
                        <a class="cart-remove text-danger"  wire:click="deleteFromCart({{$cartProduct->id}})" title="quitar producto">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>

                </div>
            </div>

        @endforeach
    @else
        <h6 class="h-100 text-muted d-flex align-items-center justify-content-center">
            {{trans('icommerce::cart.articles.empty_cart')}}
        </h6>
    @endif
</div>