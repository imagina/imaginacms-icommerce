@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')

    <!-- preloader -->
    <div id="content_preloader"><div id="preloader"></div></div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('icommerce::common.home.title')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{trans('icommerce::cart.breadcrumb_title')}}</li>
                        </ol>
                    </nav>

                    <h2 class="text-center mt-0 mb-5">{{trans('icommerce::cart.title')}}</h2>

                </div>
            </div>
        </div>
    </div>

    <!-- ======== @Region: #content ======== -->
    <div id="content" class="pb-5">

        <div class="container">

            <!-- Shopping cart -->
            <div class="cart-content" v-show="items">
                <div class="wrapper-cart-table">
                    <!--Shopping cart items-->
                    <table class="table table-responsive mb-0 cart-table">
                        <thead>
                        <tr>
                            <th class="w-5"></th>
                            <th class="w-10"></th>
                            <th class="w-20 text-center">{{trans('icommerce::cart.table.item')}}</th>
                            <th class="w-20 text-center">{{trans('icommerce::cart.table.sku')}}</th>
                            <th class="w-20 text-center">{{trans('icommerce::cart.table.unit_price')}}</th>
                            <th class="w-15 text-center">{{trans('icommerce::cart.table.quantity')}}</th>
                            <th class="w-20 text-md-right">{{trans('icommerce::cart.table.subtotal')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Cart item 1 -->
                        <tr v-for="item in items">
                            <td class="text-center align-middle">
                                <a class="close cart-remove"
                                   v-on:click="delete_item(item.id)">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a v-bind:href="item.url">
                                    <img class="cart-img img-fluid"
                                         v-bind:src="item.mainimage"
                                         v-bind:alt="item.name">
                                </a>
                            </td>
                            <td>
                                <span class="font-weight-bold" style="color: black">
                                    <a v-bind:href="item.url">
                                        @{{ item.name }}
                                    </a>
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                @{{ item.sku }}
                            </td>
                            <td class="text-center align-middle">
                                @{{ currency.symbol_left }} @{{ item.format_price }}
                            </td>
                            <td>
                                <div class="input-group" >
                                    <div class="input-group-prepend">
                                        <input type="button" value="-"
                                               class="btn btn-outline-primary border-right-0 quantity-down"
                                               field="quantity"
                                               v-on:click="item.quantity > 0 ? update_quantity(item, '-') : alerta('{{trans('icommerce::cart.message.min_exceeded')}}', '{{trans('icommerce::cart.alerts.error')}}')">
                                    </div>
                                    <input type="text"
                                           name="quantity"
                                           v-model="item.quantity"
                                           class="quantity form-control border-primary"
                                           v-on:change="update_cart(item)">
                                    <div class="input-group-append">
                                        <input type="button" value="+"
                                               class="btn btn-outline-primary border-left-0 quantity-up"
                                               field="quantity"
                                               v-on:click="update_quantity(item, '+')">
                                    </div>
                                </div>
                            </td>
                            <td class="text-md-right">
                                <span class="font-weight-bold">
                                    @{{ currency.symbol_left }} @{{ formatPrice(item.quantity * item.price) }}
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--End of Shopping cart items-->
                <hr class="my-4 hr-lg">
                <div class="cart-content-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <!--
                            <h6 class="text-muted mb-3">
                                All prices are including VAT
                            </h6>

                            <form action="#" role="form">
                                <div class="input-group">
                                    <label class="sr-only" for="discount">Discount code</label>
                                    <input type="tel" class="form-control" id="discount" placeholder="Discount code">
                                    <span class="input-group-btn">
                                      <button class="btn btn-dark border-left-0" type="button">Go</button>
                                    </span>
                                </div>
                            </form>
                            -->
                        </div>
                        <div class="col-md-8 text-right mt-3 mt-md-0">
                            <div class="cart-content-totals">
                                <h4 class="">
                                    {{trans('icommerce::cart.table.total')}}<span class="text-primary"> @{{ currency.symbol_left }} @{{ monto }}</span>
                                </h4>
                                <hr class="my-3 w-50 mr-0">
                            </div>
                            <!-- Proceed to checkout -->
                            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">{{trans('icommerce::cart.button.continue_shopping')}}</a>
                            <a href="{{ url('checkout') }}" class="btn btn-primary btn-rounded btn-lg my-2">{{trans('icommerce::cart.button.proceed_to_checkout')}}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div  class="alert alert-primary" role="alert" v-show="!items">
                {{trans('icommerce::cart.empty_cart_message.part_1')}}<a href="{{ url('/') }}" class="alert-link">{{trans('icommerce::cart.empty_cart_message.part_2')}}</a>{{trans('icommerce::cart.empty_cart_message.part_3')}}
            </div>

        </div>

    </div>


@endsection

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script type="text/javascript">
        const vue_cart_primary = new Vue({
            el: '#content',
            created: function () {
                this.$nextTick(function () {
                    this.get_articles();
                    setTimeout(function () {
                        $('#content_preloader').fadeOut(1000, function () {
                            $('#content').animate({'opacity': 1}, 500);
                        });
                    }, 1800);
                });
            },
            data: {
                items: [],
                monto: 0.0,
                currency: {!! $currency ? $currency : "''"!!},
            },
            methods: {
                /*obtiene los producto*/
                get_articles: function () {
                    var path = '{{ route('icommerce.api.get.cart') }}';
                    axios.get(path).then(function(response){
                        vue_cart_primary.update_dates(response.data);
                    });
                },

                /* actualiza la cantidad del producto antes de enviarlo */
                update_quantity: function (item, sign) {
                    sign === '+' ?
                        item.quantity++ :
                        item.quantity--;
                    vue_cart_primary.update_cart(item);
                },

                /* actualiza el item del carrito */
                update_cart: function (item) {
                    axios.post('{{ route("icommerce.api.update.item.cart") }}', item).then(function(response){
                        vue_carting.get_articles();
                        vue_cart_primary.update_dates(response.data);
                    });
                },

                /*elimina todos los productos*/
                clear_cart: function () {
                    var path = '{{ route('icommerce.api.clear.cart') }}';
                    axios({
                        method: 'post',
                        responseType: 'json',
                        url: path
                    }).then(function(response){
                        vue_cart_primary.update_dates(response.data);
                    });
                },

                /*actualiza los datos para el carrito*/
                update_dates: function (data) {
                    this.items = data.quantity >= 1 ? data.items : false;
                    this.monto = data.total;
                },

                /*elimina un item del carrito*/
                delete_item: function (item_id) {
                    var path = '{{ route('icommerce.api.delete.item.cart') }}?id='+item_id;
                    axios({
                        method: 'post',
                        responseType: 'json',
                        url: path
                    }).then(function(response ){
                        vue_cart_primary.update_dates(response.data);
                        vue_carting.update_dates(response.data);
                    });
                },

                /*onclick para la imagen del producto*/
                location: function(url){
                    window.location = url;
                },

                /* format price */
                formatPrice: function (value) {
                    let val = (value/1).toFixed(2);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },

                alerta: function (menssage, type) {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr[type](menssage);
                }
            }
        });
    </script>
@stop