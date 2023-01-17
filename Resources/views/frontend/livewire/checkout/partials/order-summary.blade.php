<div id="cardOrderSummary" class="card card-block order p-3">
    <div class="row">
        <div class="col">
            <div class="row m-0 pointer" data-toggle="collapse" href="#CheckList" role="button" aria-expanded="false"
                 aria-controls="CheckList">
                <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-2 py-2">
                    <i class="fa fa-check px-1"></i>
                </div>
                <h3 class="d-flex align-items-center h5">
                    {{ trans('icommerce::order_summary.title') }}
                </h3>
            </div>

            <div id="CheckList" class="collapse show">

                <hr class="my-2"/>

                <div class="row">

                    <div class="col">
                        <h5 class="dropdown-header mb-0">
                            {{$cart->products->count()}}
                            @if($cart->products->count()>1)
                                <span>{{ trans('icommerce::order_summary.items_car') }}</span>
                            @else
                                <span>{{ trans('icommerce::order_summary.item_car') }}</span>
                            @endif
                        </h5>
                        <hr class="mt-0 mb-3"/>
                        <div class="box-items-cart">
                            <!-- CART | ITEMS -->
                            @if($cart->products->count())
                                @foreach($cart->products as $cartProduct)

                                    <div class="item_carting px-3 w-100 row m-0">
                                        <hr class="mt-0 mb-3 w-100">

                                    @php($mediaFiles = $cartProduct->product->mediaFiles())
                                    @php($withImage = !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
                                    @if($withImage)
                                        <!-- imagen -->
                                        <div class="col-3 px-0 mb-3">
                                            <div class="img-product-cart">
                                                <x-media::single-image
                                                        :alt="$cartProduct->product->name"
                                                        :title="$cartProduct->product->name"
                                                        :url="$cartProduct->product->url"
                                                        :isMedia="true"
                                                        imgClasses="img-fluid"
                                                        :mediaFiles="$cartProduct->product->mediaFiles()"/>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- descripción -->
                                        <div class="{{$withImage ? 'col-9' : 'col-12'}}">

                                            <!-- titulo -->
                                            <h6 class="mb-2 w-100 __title">
                                                <a href="{{$cartProduct->product->url}}">
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
                                                {{trans('icommerce::cart.table.quantity')}}
                                                : {{ $cartProduct->quantity }} <br>
                                                {{trans('icommerce::cart.table.price_per_unit')}}
                                                : {{isset($currency) ? $currency->symbol_left : '$'}}
                                                {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
                                            </p>

                                            @if($cartProduct->product->shipping)
                                                <p>
                                                    <small>
                                                        <i class="fa fa-truck"
                                                           aria-hidden="true"></i> {{trans("icommerce::products.table.shipping")}}
                                                    </small>
                                                </p>
                                        @endif
                                        <!-- boton para eliminar-->
                                            <div style="width: 20px;  position: absolute; right: -7px; top: 0;">
                                                <a class="close cart-remove text-danger" style="font-size: 1rem;"
                                                   onclick="window.livewire.emit('deleteFromCart',{{$cartProduct->id}})"
                                                   title="quitar producto">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr class="mt-1 mb-2"/>
                        <div class="dropdown-footer col-12">

                            <!-- CART | SUB TOTAL -->
                            <div class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.car_sub') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                    <div>
                                        {{isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney( $cart->total )}} {{isset($currency) ? $currency->symbol_right : ''}}
                                    </div>

                                    </p>
                                </div>
                            </div>

                            <!--  COUPON | CODE AND AMOUNT -->
                            @if(isset($couponSelected->id))
                            <div class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.coupon') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                        <div>
                                            {{ trans('icommerce::order_summary.couponCode') }}
                                            {{$couponSelected->code }}
                                            <br>
                                                {{ isset($currency) ? $currency->symbol_left : '$'}} {{ "(".formatMoney($couponDiscount->discount).")" }} {{isset($currency) ? $currency->symbol_right : ''}}

                                        </div>

                                        </p>
                                </div>
                            </div>
                            @endif

                            @if(!empty($totalTaxes))
                            <!--  TAXES  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                        <div>{{ trans('icommerce::order_summary.taxes') }}</div>
                                        </p>
                                    </div>
                                    @foreach($totalTaxes as $totalTax)
                                    <div class="col-5">

                                        <div>{{ $totalTax["rateName"] ."  (".$totalTax['rate'].")"  }}</div>

                                    </div>
                                    <div class="col-7 text-right">

                                            {{ isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($totalTax["totalTax"])}}{{isset($currency) ? $currency->symbol_right : ''}}

                                    </div>
                                    @endforeach
                                </div>
                                @endif

                        @if($requireShippingMethod)
                            <!--  SHIPPING METHOD | TITLE AND AMOUNT -->
                            <div class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.shipping') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                    @if(!isset($shippingMethod->id))
                                        <div>
                                            {{ trans('icommerce::order_summary.shipping_not_selected')}}
                                        </div>
                                    @else
                                        <div>
                                            {{$shippingMethod->title }}
                                            <br>
                                            @if(isset($shippingMethod->calculations->priceshow) && $shippingMethod->calculations->priceshow)
                                                {{ isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney($shippingMethod->calculations->price) }} {{isset($currency) ? $currency->symbol_right : ''}}
                                            @endif
                                        </div>
                                        @endif
                                        </p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <hr class="mt-0 mb-1"/>
                        <div class="dropdown-footer">
                            <div class="card border-0">
                                <div class="card-header bg-white" id="couponHeadline">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#couponCollapse" aria-expanded="true"
                                                aria-controls="couponHeadline">
                                            {{ trans('icommerce::coupons.title.addCoupon') }}
                                        </button>
                                    </h5>

                                </div>
                                <div class="card-body">
                                <div id="couponCollapse" class="collapse w-100" aria-labelledby="couponHeadline">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input id="couponCode" placeholder="{{trans("icommerce::coupons.title.typeCoupon")}}" class="form-control" type="text"/>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-sm btn-outline-primary w-100"
                                                            wire:click="validateCoupon(document.getElementById('couponCode').value)">
                                                        {{ trans('icommerce::coupons.title.aplyCoupon') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-4">
                                    <h6>
                                        {{ trans('icommerce::order_summary.total') }}
                                    </h6>
                                </div>
                                <div class="col-8">
                                    <h5 class="font-weight-bold text-right">

                                        {{ isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney($total) }} {{isset($currency) ? $currency->symbol_right : ''}}

                                    </h5>

                                </div>
                            </div>

                            <!--  PAYMENT METHOD | TITLE AND DESCRIPTION -->
                            <div class="row">
                                <div class="col-4">
                                    <div>{{ trans('icommerce::order_summary.payment') }}</div>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                        {{$paymentMethod->title ?? trans("icommerce::paymentmethods.messages.noPaymentMethodSelected") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button type="button" class="btn btn-warning btn-lg w-100 mt-3 placeOrder" wire:click="{{config("asgard.icommerce.config.livewirePlaceOrderClick")}}">

                        <div>
                            {{ trans('icommerce::order_summary.submit') }}
                        </div>

                </button>
            </div>
        </div>
    </div>
</div>
