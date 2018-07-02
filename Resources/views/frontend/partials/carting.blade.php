{{--@section('carting')
    <!--Shopping cart-->
    <div id="carting" class="nav-item dropdown">
        <a class="nav-link active bg-primary text-white dropdown-toggle" href="#" role="button" id="dropdownCart"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-cart"></i> <span class="d-none d-sm-inline-block">MY CART</span> (@{{ cantidad }})
        </a>
        <!--Shopping cart dropdown -->
        <div class="dropdown-menu cart-dropdown-menu" aria-labelledby="dropdownCart" style="width: 360px">
            <h5 class="dropdown-header mb-0 font-weight-bold text-center" v-show="isCart">
                Your Shopping Cart
            </h5>
            <h5 class="dropdown-header mb-0 font-weight-bold text-center" v-show="!isCart">
                You have no items in your shopping cart.
            </h5>
            <hr class="mt-0 mb-3" v-show="isCart">
            <!--Shopping cart items-->
            <div class="cart-items px-3" v-for="item in articulos">
                <!--Shopping cart item 1 -->
                <div class="cart-items-item row">
                    <a v-bind:href="item.slug" class="cart-img mr-2 float-left col-3">
                        <img v-if="item.image.mainimage != null" class="img-fluid"
                             v-bind:src="item.image.mainimage"
                             v-bind:alt="item.name">
                        <img v-else class="img-fluid"
                             src="http://local.imagina.com.co:82/labs/appstrap3.0.11/theme/assets/img/shop/gloves-1-thumb.jpg"
                             v-bind:alt="item.name">
                    </a>
                    <div class="float-left col-7">
                        <div class="row">
                            <h6 class="mb-0 w-100">
                                <a v-bind:href="item.slug">
                                    @{{ item.name }}
                                </a>
                            </h6>
                            <p class="mb-0" style="font-size: 10px">$ @{{ item.price }} x @{{ item.quantity }}</p>
                        </div>
                    </div>
                    <a class="close cart-remove text-primary" v-on:click="deleteItem(item)">
                        <i class="fa fa-times"></i>
                    </a>
                </div>

            </div>
            <!--End of Shopping cart items-->
            <hr class="mt-3 mb-3" v-show="isCart">
            <div class="dropdown-footer text-center" v-show="isCart">
                <h6 class="font-weight-bold">
                    Total: <span class="text-primary">$ @{{ subTotal }}</span>
                </h6>
                <a href="{{ url('checkout/cart') }}" tabindex="-1"
                   class="btn btn-outline-primary btn-sm btn-rounded mx-1">View Cart</a>
                <a href="{{ url('checkout') }}" tabindex="-1"
                   class="btn btn-warning btn-sm btn-rounded mx-1">Checkout</a>
            </div>
        </div>
    </div>
    <!-- end of shopping cart -->
@stop


@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script type="text/javascript">
        var carting = new Vue({
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
                cantidad: 0,
                isCart: false
            },
            methods: {
                getArticulos: function () {
                    axios.get('{{ url("api/icommerce/items_cart") }}')
                        .then(response => {
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

                        if (window.obj) {
                            obj.alerta("Se elimino el producto del carrito", "success");
                            if (obj.items) {
                                obj.items = response.data.items;
                                obj.updatePrecio(response.data.items);
                            }
                        }

                        if (window.checkout) {
                            checkout.articulos = response.data.items;
                            checkout.updatePrecio(response.data.items);
                            checkout.cantidad = response.data.cantidad;
                        }

                    }).catch(error => {
                            console.log(error);
                    });
                },
                updatePrecio: function (items) {
                    this.subTotal = 0.0;
                    this.isCart = false;
                    for (var index in items) {
                        this.isCart = true;
                        this.subTotal = this.subTotal + (items[index].price * items[index].quantity);
                    }

                    this.subTotal = Math.round(this.subTotal*100)/100;
                }
            }
        });
    </script>
@stop
--}}