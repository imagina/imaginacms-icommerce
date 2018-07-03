<div id="content_carting" class="bg-primary">
    <!-- BUTTOM -->
    <a class="dropdown-toggle text-primary"
       id="dropdownCart"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">

        <a class="nav-link active text-white dropdown-toggle d-none d-lg-block d-xl-block"
           href="#"
           role="button"
           id="dropdownCart"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <i class="fa fa-shopping-cart"></i>
            <span class="d-none d-sm-inline-block">
                MY CART
            </span>
            (@{{ quantity }})
        </a>
    </a>

    <!---->
    <a class="dropdown-toggle text-primary"
       id="dropdownCart">

        <a class="nav-link active text-white dropdown-toggle d-lg-none d-xl-none"
           href="{{ url('checkout/cart') }}"
           role="button"
           id="dropdownCart">
            <i class="fa fa-shopping-cart"></i>
            <span class="d-none d-sm-inline-block">
                MY CART
            </span>
            (@{{ quantity }})
        </a>
    </a>

    <!--Shopping cart-->
    <div class="nav-item cart-dropdown-menu"
         aria-labelledby="dropdownCart"
         style="z-index: 99999;">
        <!--Shopping cart dropdown -->
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="dropdownCart"
             style="width: 360px; z-index: 9999999">
            <!-- titulo -->
            <h4 class="dropdown-header mb-0 font-weight-bold text-center"
                v-if="articles">
                shopping cart
                <i class="fa fa-trash text-muted float-right"
                   title="Vaciar carrito"
                   v-on:click="clear_cart()"></i>
            </h4>
            <h5 class="dropdown-header mb-0 font-weight-bold text-center"
                v-if="!articles">
                empty shopping cart
            </h5>

            <!-- articulos en el carrito -->
            <div class="item_carting px-3 w-100 row m-0"
                 v-for="item in articles"
                 v-if="articles">
                <hr class="mt-0 mb-3 w-100">

                <!-- imagen -->
                <div class="img_product_carting mr-3 border"
                     v-bind:style="{ backgroundImage: 'url('+item.mainimage+')'}"
                     v-on:click="location(item.url)"
                     style="cursor: pointer;">
                </div>

                <!-- descripción -->
                <div class="col-7">
                    <div class="row">
                        <!-- titulo -->
                        <h6 class="mb-2 w-100">
                            <a v-bind:href="item.url">
                                @{{ item.name }}
                            </a>
                        </h6>
                        <!-- valor y cantidad -->
                        <p class="mb-0 text-muted pb-2"
                           style="font-size: 14px">
                            Quantity: @{{ item.quantity }} <br>
                            Price/Und: $ @{{ item.format_price }}
                        </p>
                    </div>
                </div>

                <!-- boton para eliminar-->
                <div class="text-right" style="width: 35px">
                    <a class="close cart-remove text-danger"
                       v-on:click="delete_item(item.id)"
                       title="quitar producto">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <!-- FOOTER CARTING -->
            <div class="dropdown-footer text-center"
                 v-if="articles">
                <hr class="mt-3 mb-3">
                <!-- total -->
                <h6 class="font-weight-bold">
                    Total:
                    <span class="text-primary">
                        $ @{{ total }}
                    </span>
                </h6>
                <!-- botones-->
                <a href="{{ url('checkout/cart') }}"
                   tabindex="-1"
                   class="btn btn-primary text-white">
                    View Cart
                </a>
                <a href="{{ url('checkout') }}"
                   tabindex="-1"
                   class="btn btn-warning mx-1 text-white">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script type="text/javascript">

        var vue_carting = new Vue({
            el: '#content_carting',
            mounted: function () {
                this.$nextTick(function () {
                    this.get_articles();
                });
            },
            data: {
                articles: false,
                total: 0,
                quantity: 0,
                currency: {!! $currency ? $currency : "''"!!},
            },
            methods: {
                /*obtiene los producto*/
                get_articles: function () {
                    var path = '{{ route('icommerce.api.get.cart') }}';
                    axios.get(path).then(function(response){
                        vue_carting.update_dates(response.data);
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
                        vue_carting.update_dates(response.data);
                    });
                },

                /*actualiza los datos para el carrito*/
                update_dates: function (data) {
                    this.articles = data.quantity >= 1 ? data.items : false;
                    this.quantity = data.quantity;
                    this.total = data.total;
                },

                /*elimina un item del carrito*/
                delete_item: function (item_id) {
                    var path = '{{ route('icommerce.api.delete.item.cart') }}?id='+item_id;
                    axios({
                        method: 'post',
                        responseType: 'json',
                        url: path
                    }).then(function(response ){
                        vue_carting.update_dates(response.data);
                        if (window.checkout) {
                            checkout.getArticulos();
                        }
                    });
                },

                /*onclick para la imagen del producto*/
                location: function(url){
                    window.location = url;
                }
            }
        });
    </script>
@stop
