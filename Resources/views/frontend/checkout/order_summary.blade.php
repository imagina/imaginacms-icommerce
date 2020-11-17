<div class="card card-block order p-3">
    <div class="row">
        <div class="col">
            <div class="row m-0 pointer" data-toggle="collapse" href="#CheckList" role="button" aria-expanded="false" aria-controls="CheckList">
                <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-2 py-1">
                    <i class="fa fa-check px-1"></i>
                </div>
                <h3 class="d-flex align-items-center my-1">
                    {{ trans('icommerce::order_summary.title') }}
                </h3>
            </div>

            <div id="CheckList" class="collapse show">

                <hr class="my-2"/>

                <div class="row">

                    <div class="col">
                        <h5 class="dropdown-header mb-0">
                            @{{ quantity }}
                            <span v-if="quantity>1">{{ trans('icommerce::order_summary.items_car') }}</span>
                            <span v-else>{{ trans('icommerce::order_summary.item_car') }}</span>
                        </h5>
                        <hr class="mt-0 mb-3"/>
                        <div class="box-items-cart">
                            <div class="row item_carting pr-3 w-100 m-0" v-for="item in cart.products">
                                <div class="col-3 px-0 pb-2">
                                    <a v-if="item.product.mediaFiles.mainimage.smallThumb"
                                       v-bind:href="item.product.url" class="cart-img float-left">
                                        <img v-if="item.product.mediaFiles.mainimage.smallThumb" class="img-fluid"
                                             v-bind:src="item.product.mediaFiles.mainimage.smallThumb"
                                             v-bind:alt="item.product.name">
                                        <img v-else class="img-fluid"
                                             src="{{url('modules/icommerce/img/product/default.jpg')}}"
                                             v-bind:alt="item.product.name">
                                    </a>
                                </div>
                                <div class="col-9">

                                    <a class="close cart-remove text-primary float-right"
                                       :onClick="'window.livewire.emit(\'deleteFromCart\','+item.id+')'"
                                       v-on:click="deleteProductOfCart(item)"> <i
                                                class="fa fa-times"></i> </a>
                                    <h5 class="mb-0 text-center">
                                        @{{ item.name }}
                                    </h5>
                                    <p class="mb-0 text-center" v-if="item.productOptionValues.length > 0">
                                      <label v-for="opt in item.productOptionValues" class="mr-3">
                                        <strong>@{{opt.optionValue}}</strong>
                                      </label>
                                    </p>
                                    <p class="mb-0 text-center">
                                        @{{ item.priceUnit | numberFormat }}

                                        @{{ '/ x '+item.quantity }}
                                    </p>
                                    <div class="col-7 p-0 mb-2 mx-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <input type="button" value="-"
                                                       class="btn btn-outline-primary border-right-0 quantity-down"
                                                       field="quantity"
                                                       v-on:click="item.quantity > 0 ? update_quantity(item, '-') : alert('La cantidad no puede ser menor a 1', 'error')">
                                            </div>
                                            <input type="text"
                                                   name="quantity"
                                                   v-model="item.quantity"
                                                   readonly
                                                   style="text-align:center"
                                                   class="quantity form-control border-primary"
                                                   v-on:change="update_cart(item)">
                                            <div class="input-group-append">
                                                <input type="button" value="+"
                                                       class="btn btn-outline-primary border-left-0 quantity-up"
                                                       field="quantity"
                                                       v-on:click="(item.quantity < item.product.quantity) ? update_quantity(item, '+') : false">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-3 w-100">
                            </div>
                        </div>
                        <hr class="mt-1 mb-2"/>
                        <div class="dropdown-footer">
                            <div class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.car_sub') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                    <div v-if="!updatingData">
                                        @{{ orderTotal | numberFormat }}
                                        {{--@{{ subTotal | numberFormat }}--}}

                                    </div>
                                    <div v-else>
                                        <i class="fa fa-spinner fa-pulse"></i>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.shipping') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                    <div v-if="!updatingData">
                                        <div v-if="! shipping_name">
                                            {{ trans('icommerce::order_summary.shipping_not_selected')}}

                                        </div>
                                        <div v-else>
                                            @{{shipping_title }}
                                            <br>
                                            @{{ shipping!=0 ? shipping : '' | numberFormat }}

                                        </div>
                                    </div>
                                    <div v-else>
                                        <i class="fa fa-spinner fa-pulse"></i>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div v-show="tax" class="row">
                                <div class="col-4">
                                    <p>
                                    <div>{{ trans('icommerce::order_summary.tax') }}</div>
                                    </p>
                                </div>
                                <div class="col-8 text-right">
                                    <p>
                                    <div v-if="!updatingData">

                                        @{{ taxTotal | numberFormat }}

                                    </div>
                                    <div v-else>
                                        <i class="fa fa-spinner fa-pulse"></i>
                                    </div>
                                    </p>
                                </div>

                            </div>
                            <input type="hidden" name="tax_amount" v-model="taxTotal">
                        </div>

                        <hr class="mt-0 mb-1"/>
                        <div class="dropdown-footer">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="font-weight-bold">
                                        <div>{{ trans('icommerce::order_summary.total') }}</div>
                                    </h5>
                                </div>
                                <div class="col-8">
                                    <h5 class="font-weight-bold text-right" v-if="!updatingData">

                                        @{{ orderTotal | numberFormat }}

                                    </h5>
                                    <h5 v-else>
                                        <i class="fa fa-spinner fa-pulse"></i>
                                    </h5>
                                    <input type="hidden" name="total" id="total" :value="orderTotal">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @{{calculate_total}}
                <button type="button" class="btn btn-warning btn-lg w-100 mt-3 placeOrder" @click="submitOrder($event)"
                :disabled="placeOrderButton || updatingData">
                <div v-if="quantity>0" v-show="!placeOrderButton && !updatingData">
                    {{ trans('icommerce::order_summary.submit') }}
                </div>
                <div class="fa-1x" v-show="placeOrderButton">
                    <i class="fa fa-spinner fa-pulse"></i> {{ trans('icommerce::order_summary.sending') }}
                </div>
                <div class="fa-1x" v-show="updatingData">
                    <i class="fa fa-spinner fa-pulse"></i>
                </div>
                </button>
            </div>
        </div>
    </div>
</div>
