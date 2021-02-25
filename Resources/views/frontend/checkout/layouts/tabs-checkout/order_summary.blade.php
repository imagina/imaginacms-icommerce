<div class="card-ckeckout card-ckeckout-summary">

    <h4 class="ckeckout-subtitle-primary">
        {{ trans('icommerce::order_summary.title') }}
    </h4>

    <div id="CheckList" class="pt-3">

        <h5 class="dropdown-header mb-0 border-top border-bottom">
            @{{ quantity }}
            <span v-if="quantity>1">{{ trans('icommerce::order_summary.items_car') }}</span>
            <span v-else>{{ trans('icommerce::order_summary.item_car') }}</span>
        </h5>
        <div class="box-items-cart">
            <div class="item_carting border-bottom pt-3" v-for="item in cart.products">
                <div class="row ">
                    <div class="col-3 pr-0 pb-2">
                        <a v-if="item.product.mediaFiles.mainimage.smallThumb"
                           v-bind:href="item.product.url" class="cart-img">
                            <img v-if="item.product.mediaFiles.mainimage.smallThumb" class="img-fluid"
                                 v-bind:src="item.product.mediaFiles.mainimage.smallThumb"
                                 v-bind:alt="item.product.name">
                            <img v-else class="img-fluid"
                                 src="{{url('modules/icommerce/img/product/default.jpg')}}"
                                 v-bind:alt="item.product.name">
                        </a>
                    </div>
                    <div class="col pr-0">

                        <h6 class="item_carting-product-name font-weight-bold mb-0">
                            @{{ item.name }}
                        </h6>
                        <p class="mb-0" v-if="item.productOptionValues.length > 0">
                            <label v-for="opt in item.productOptionValues" class="mr-3">
                                <strong>@{{opt.optionValue}}</strong>
                            </label>
                        </p>
                        <p class="item_carting-product-price mb-0">
                            @{{ item.priceUnit | numberFormat }}
                                @{{ ' x '+item.quantity }}
                        </p>
                        <div class="quantity-group p-0 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="button" value="-"
                                           class="btn btn-outline-primary btn-sm quantity-down"
                                           field="quantity"
                                           v-on:click="item.quantity > 0 ? update_quantity(item, '-') : alert('La cantidad no puede ser menor a 1', 'error')">
                                </div>
                                <input type="text"
                                       name="quantity"
                                       v-model="item.quantity"
                                       readonly
                                       style="text-align:center"
                                       class="quantity form-control form-control-sm border-primary"
                                       v-on:change="update_cart(item)">
                                <div class="input-group-append">
                                    <input type="button" value="+"
                                           class="btn btn-outline-primary btn-sm quantity-up"
                                           field="quantity"
                                           v-on:click="(item.quantity < item.product.quantity) ? update_quantity(item, '+') : false">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a class="close cart-remove text-danger"
                           :onClick="'window.livewire.emit(\'deleteFromCart\','+item.id+')'"
                           v-on:click="deleteProductOfCart(item)"> <i
                                    class="fa fa-times"></i> </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown-footer border-bottom">
            <div class="row py-2">
                <div class="col-4">
                    <div>{{ trans('icommerce::order_summary.car_sub') }}</div>
                </div>
                <div class="col-8 text-right">
                    <div v-if="!updatingData">
                        {{--@{{ orderTotal | numberFormat }}--}}
                        @{{ calculate_subtotal | numberFormat }}
                    </div>
                    <div v-else>
                        <i class="fa fa-spinner fa-pulse"></i>
                    </div>
                </div>
            </div>
            <div class="row py-2">
                <div class="col-4 ">
                    <div>{{ trans('icommerce::order_summary.shipping') }}</div>
                </div>
                <div class="col-8 text-right">
                    <div v-if="!updatingData">
                        <div v-if="! shipping_name">
                            {{ trans('icommerce::order_summary.shipping_not_selected')}}

                        </div>
                        <div v-else>
                            @{{shipping_title }}
                            <br>
                            @{{ (shipping!=0 ? shipping : '') | numberFormat }}
                        </div>
                    </div>
                    <div v-else>
                        <i class="fa fa-spinner fa-pulse"></i>
                    </div>
                </div>
            </div>
            <div v-show="tax" class="row py-2">
                <div class="col-4">
                    <div>{{ trans('icommerce::order_summary.tax') }}</div>
                </div>
                <div class="col-8 text-right">
                    <div v-if="!updatingData">
                        @{{ taxTotal | numberFormat }}
                    </div>
                    <div v-else>
                        <i class="fa fa-spinner fa-pulse"></i>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tax_amount" v-model="taxTotal">
        </div>
        <div class="dropdown-footer">
            <div class="row py-2">
                <div class="col-4">
                    <h6 class="font-weight-bold">
                        <span>{{ trans('icommerce::order_summary.total') }}</span>
                    </h6>
                </div>
                <div class="col-8">
                    <h5 class="font-weight-bold text-right" v-if="!updatingData">

                        @{{ calculate_total | numberFormat }}

                    </h5>
                    <h5 v-else>
                        <i class="fa fa-spinner fa-pulse"></i>
                    </h5>
                    <input type="hidden" name="total" id="total" :value="orderTotal">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-warning font-weight-bold btn-lg w-100 mt-3 placeOrder" @click="submitOrder($event)"
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