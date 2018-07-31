<template>
    <carousel :scrollPerPage="true" :perPageCustom="[[0, 1], [480, 2], [768, 3], [920, 5]]" :autoplay="true" :speed="300"
              :loopenable="true">
        <slide v-for="item in articles" v-bind:key="item.id">
        <div class="item">
            <div class="content-img">
                <a v-bind:href="item.url">
                    <img class="border background_image align-self-center d-block mx-auto"
                         v-bind:src="item.mainimage"
                         v-bind:alt="item.title"
                         style="max-height: 100%">
                </a>
                <div class="discount font-weight-bold px-2 py-1" v-if="item.discount"></div>
                <div class="new font-weight-bold px-2 py-1" v-if="item.new">NUEVO</div>

                <div class="capa">

                    <div class="quickview text-uppercase font-weight-bold text-center py-3">
                        <a v-bind:href="item.url">
                            vista rapida
                        </a>
                    </div>

                    <a class="btn-add-cart btn btn-outline-secondary px-2 py-1"
                       v-on:click="$emit('add-cart',item)" v-if="item.price > 0">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </a>

                    <a class="btn-add-wishlist btn btn-outline-secondary px-2 py-1"
                       v-on:click="$emit('add-wishlist',item)"
                       v-if="item.price > 0">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>

                </div>

            </div>

            <div class="content text-center mt-2">

                <!-- estrellas -->
                <div class="text-center">
                        <span class="rating">
                            <i class="fa fa-star pr-1"
                               v-bind:class="[item.rating >= star ? 'text-secondary' : 'text-muted']"
                               v-for="star in 5"></i>
                        </span>
                </div>

                <h4>
                    <a v-bind:href="item.url">
                        {{ item.title }}
                    </a>
                </h4>

                <div class="prices mb-3">
                    <div class="price-old font-weight-bold float-left ml-2" v-if="item.unformatted_price_discount">
                        <del>{{currencysymbolleft +' '+ item.price_discount +' '+ currencysymbolright }}</del>
                    </div>
                    <div class="price-old font-weight-bold float-left ml-2" v-else>
                        <del>{{currencysymbolleft +' '+ item.price +' '+ currencysymbolright }}</del>
                    </div>
                </div>
            </div>
        </div>
        </slide>
    </carousel>
</template>
<script>
    export default {
        props:[
            'take'
        ],
        data() {
            return {
                articles: [],
                currencysymbolleft: icommerce.currencySymbolLeft,
                currencysymbolright: icommerce.currencySymbolRight,
                loading: true,
            }
        },
        components: {
            'carousel': VueCarousel.Carousel,
            'slide': VueCarousel.Slide
        },
        mounted: function () {
            this.$nextTick(function () {
                this.getData();
            });
        },
        methods: {
            getData: function () {
                let uri = icommerce.url + '/api/icommerce/v2/products?filters={"bestsellers":true,"take":'+take+'}';
                axios
                    .get(uri)
                    .then(response => {
                        this.articles = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false
                    )
            }
        },
    }
</script>