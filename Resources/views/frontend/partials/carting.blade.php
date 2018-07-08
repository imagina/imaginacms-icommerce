@section('carting')
    <!--Shopping cart-->
    <div id="carting" class="dropdown">
        <!--
        <a class="nav-link bg-primary text-white dropdown-toggle" href="#" role="button" id="dropdownCart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-cart"></i> <span class="d-none d-sm-inline-block">MY CART</span> (0)
        </a>-->
        <a href="#" class="btn btn-icon btn-dark btn-link float-right dropdown-toggle cart-link" data-toggle="dropdown">
            <span class="cart-link-icon">
                <i class="fa fa-shopping-cart"></i>
                <span class="sr-only">{{trans('icommerce::cart.carting.title')}}</span>
                <span class="cart-link-count bg-primary text-white">@{{ cantidad }}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow cart-dropdown-menu" role="menu" >
            <p class="dropdown-header mb-0">
                {{trans('icommerce::cart.carting.your_cart')}}
            </p>
            <hr class="mt-0 mb-3" />
            <!--Shopping cart dropdown -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow cart-dropdown-menu" role="menu">
                <p class="dropdown-header mb-0">
                    {{trans('icommerce::cart.carting.your_cart')}}
                </p>
                <hr class="mt-0 mb-3" />
                <!--Shopping cart items-->
                <div class="cart-items" v-for="item in articulos">
                    <!--Shopping cart item 1 -->
                    <div class="cart-items-item">

                        <a href="#" class="cart-img mr-2 float-left">
                            <img class="img-fluid" src="http://local.imagina.com.co:82/labs/appstrap3.0.11/theme/assets/img/shop/gloves-1-thumb.jpg" v-bind:alt="item.name">
                        </a>
                        <div class="float-left">
                            <p class="mb-0">
                                @{{ item.name }}
                            </p>
                            <p class="mb-0">$ @{{ item.price }} / x @{{ item.quantity }}</p>
                            <a href="#" class="close cart-remove text-primary" v-on:click="deleteItem(item)"> <i class="fa fa-times"></i> </a>
                        </div>
                    </div>

                </div>
                <!--End of Shopping cart items-->
                <hr class="mt-3 mb-0" />
                <div class="dropdown-footer text-center">
                    <p class="font-weight-bold">
                        {{trans('icommerce::cart.table.total')}}<span class="text-primary">$ @{{ subTotal }}</span>
                    </p>
                    <a href="{{ url('checkout/cart') }}" tabindex="-1" class="btn btn-outline-primary btn-sm btn-rounded mx-2">{{trans('icommerce::cart.carting.view_cart')}}</a>
                    <a href="{{ url('checkout') }}" tabindex="-1" class="btn btn-primary btn-sm btn-rounded mx-2">{{trans('icommerce::checkout.title')}}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end of shopping cart -->
@stop


@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script type="text/javascript">
        const carting = new Vue({
            el: '#carting',
            created: function () {
                this.getArticulos();
            },
            data: {
                articulos: [

                ],
                subTotal: 0.0,
                descuento: 0.0,
                monto: 0.0,
                cantidad: 0
            },
            methods: {
                getArticulos: function () {
                    axios.get("{{ url('api/icommerce/items_cart') }}").then(response => {
                        this.articulos = response.data.items;
                        this.cantidad = response.data.cantidad;

                        this.updatePrecio(response.data.items);
                    });
                },
                deleteItem: function (item) {
                    axios.post('{{ url("api/icommerce/delete_item") }}', item)
                        .then(response => {
                        this.articulos = response.data.items;
                        this.cantidad = response.data.cantidad;
                        this.updatePrecio(response.data.items);

                        obj.items = response.data.items;
                        obj.alerta("{{trans('icommerce::checkout.alerts.remove_car')}}", "success");
                        obj.updatePrecio(response.data.items);
                    }).catch(error => {
                            console.log(error);
                    });
                },
                updatePrecio: function (items) {
                    this.subTotal = 0.0;
                    for (var index in items) {
                        this.subTotal = this.subTotal + (items[index].price * items[index].quantity);
                    }

                    this.subTotal = Math.round(this.subTotal*100)/100;
                }
            }
        });
    </script>
@stop
