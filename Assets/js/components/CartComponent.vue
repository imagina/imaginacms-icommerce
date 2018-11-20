<template>
    <div id="cart" class="dropdown">
            <a href="#" class="btn btn-icon btn-dark btn-link float-right dropdown-toggle cart-link" data-toggle="dropdown">
            <span class="cart-link-icon">
                <i class="fa fa-shopping-cart"></i>
                <span class="sr-only">{{trans('icommerce::cart.carting.title')}}</span>
                <span class="cart-link-count bg-primary text-white">{{ cart_quantity }}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow cart-dropdown-menu" role="menu">
            <p class="dropdown-header mb-0">
                {{trans('icommerce::cart.carting.your_cart')}}
            </p>
            <hr class="mt-0 mb-3"/>
            <!--Shopping cart dropdown -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow cart-dropdown-menu" role="menu">
                <p class="dropdown-header mb-0">
                    {{trans('icommerce::cart.carting.your_cart')}}
                </p>
                <hr class="mt-0 mb-3"/>
                <!--Shopping cart items-->
                <div class="cart-items" v-for="item in cart_articles">
                    <!--Shopping cart item 1 -->
                    <div class="cart-items-item">

                        <a href="#" class="cart-img mr-2 float-left">
                            <img class="img-fluid"
                                 src="http://local.imagina.com.co:82/labs/appstrap3.0.11/theme/assets/img/shop/gloves-1-thumb.jpg"
                                 v-bind:alt="item.name">
                        </a>
                        <div class="float-left">
                            <p class="mb-0">
                                {{ item.name }}
                            </p>
                            <p class="mb-0">$ {{ item.price }} / x {{ item.quantity }}</p>
                            <a href="#" class="close cart-remove text-primary" v-on:click="deleteItem(item)"> <i
                                    class="fa fa-times"></i> </a>
                        </div>
                    </div>

                </div>
                <!--End of Shopping cart items-->
                <hr class="mt-3 mb-0"/>
                <div class="dropdown-footer text-center">
                    <p class="font-weight-bold">
                        {{trans('icommerce::cart.table.total')}}<span class="text-primary">{{currencysymbolleft + subTotal + currencysymbolright}}</span>
                    </p>
                    <a href="{{ url('checkout/cart') }}" tabindex="-1"
                       class="btn btn-outline-primary btn-sm btn-rounded mx-2">{{trans('icommerce::cart.carting.view_cart')}}</a>
                    <a href="{{ url('checkout') }}" tabindex="-1" class="btn btn-primary btn-sm btn-rounded mx-2">{{trans('icommerce::checkout.title')}}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CartComponent",
        data() {
            return {
                cart_articles: [],
                currencysymbolleft: icommerce.currencySymbolLeft,
                currencysymbolright: icommerce.currencySymbolRight,
                subtotal: 0.0,
                discount: 0.0,
                cart_quantity: 0,
                loading:false,
            }
        },
        mounted: function () {
            this.$nextTick(function () {
                this.getArticles();
            });
        },
        methods: {
            getArticles: function () {
                axios
                    .get(icommerce.url + "api/icommerce/v2/cart")
                    .then(response => {
                        this.cart_articles = response.data.items;
                        this.cart_quantity = response.data.cart_quantity;
                        this.updatePrice(response.data.items);
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false
                    );
            },
            deleteItem: function (item) {
                axios.post(icommerce.url + "api/icommerce/v2/cart/delete", item)
                    .then(response => {
                        this.cart_articles = response.data.items;
                        this.cart_quantity = response.data.cart_quantity;
                        this.updatePrice(response.data.items);

                        obj.items = response.data.items;
                        obj.alert("{{trans('icommerce::checkout.alerts.remove_car')}}", "success");
                        obj.updatePrice(response.data.items);
                    }).catch(error => {
                    console.log(error);
                })
                    .finally(() => this.loading = false
                    );
            },
            updatePrice: function (items) {
                this.subTotal = 0.0;
                for (var index in items) {
                    this.subTotal = this.subTotal + (items[index].price * items[index].quantity);
                }

                this.subTotal = Math.round(this.subTotal * 100) / 100;
            }
        }
    }
</script>

<style scoped>

</style>