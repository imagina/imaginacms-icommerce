<div id="contentProductsFeatured" class="iblock general-block33" data-blocksrc="general.block33" v-show="related_products != null" >
    <div class="container">
        <div class="row">

            <div class="col-12">

                <div class="title-1 mb-4 mt-4">
                    <div class="w-100 text-center">
                        <h3 class="font-weight-bold d-inline-block px-4 pt-2">
                            RELATED PRODUCTS
                        </h3>
                        <hr class="border-primary border-2 mb-0">
                        <hr class="border-secondary w-10 border-2 mb-0">
                    </div>
                </div>

                <!-- carrousel -->
                <div id="carrusel-recents"
                     class="owl-carousel owl-theme carruselPro carruselPro2 carruselRecents pb-4"
                     data-ride="carousel-recents">

                    <!-- product -->
                    <div class="item card-product" v-for="item in related_products">
                        <!-- PRODUCT -->
                        <div class="card card-product rounded-0 mb-4">
                            <!-- image -->
                            <div class="img-overlay">
                                <div class="background_image card-img-top rounded-0"
                                     v-bind:style="{'background-image' : 'url(' + item.mainimage + ')'}">
                                </div>
                                <img v-if="item.freeshipping == 1" class="card-img-type" src="{{ Theme::url('img/free.png') }}" alt="">
                                <img v-if="item.discounts && item.freeshipping != 1" class="card-img-type"
                                     src="{{ Theme::url('img/sale.png') }}" alt="">
                                <div class="overlay">
                                    <div class="link">
                                        <a v-bind:href="item.url"
                                           class="btn btn-outline-light">
                                            QUICK VIEW
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- dates product -->
                            <div class="card-body">
                                <!-- title -->
                                <h6 class="card-title text-center font-weight-bold">
                                    <a v-bind:href="item.url" v-bind:title="item.title">
                                        @{{ item.title}}
                                    </a>
                                </h6>

                                <!-- precio del producto -->
                                <div class="row justify-content-md-center mb-1">
                                    <div class="col-md-auto">
                                        <p class="text-center font-weight-bold mb-1">
                                            <del class="text-muted pr-2"
                                                 v-if="item.price_discount"
                                                 style="font-size: 14px">
                                                @{{ currency.symbol_left }} @{{ item.price }} @{{ currency.symbol_right }}
                                            </del>
                                            <span class="text-danger font-weight-bold"
                                                  v-if="!item.price_discount">
                                                @{{ currency.symbol_left }} @{{ item.price }} @{{ currency.symbol_right }}
                                            </span>
                                            <span class="text-danger font-weight-bold"
                                                  v-if="item.price_discount">
                                                @{{ currency.symbol_left }} @{{ item.price_discount }} @{{ currency.symbol_right }}
                                            </span>
                                        <hr class=" border-primary mt-0 mx-auto mb-1 w-75 border-2">
                                        </p>
                                    </div>
                                </div>

                                <!-- STARTS -->
                                <div class="mb-2 text-center">
                                    <span style="font-size: 12px">
                                        <i class="fa fa-star pr-1"
                                           v-bind:class="[product.rating >= star ? 'text-warning' : 'text-muted']"
                                           v-for="(star,key) in 5"></i>
                                    </span>
                                </div>

                                <!-- buttons -->
                                <div class="text-center">
                                    <a class="btn btn-outline-primary"
                                       v-on:click="addCart(item)">
                                        <i class="fa fa-shopping-cart text-danger"></i>
                                    </a>
                                    <a class="btn btn-outline-primary text-primary"
                                       v-on:click="addWishList(item)">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a v-bind:href="item.url"
                                       class="btn btn-outline-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts-owl')
    <script>
        $(document).ready(function () {
            setTimeout(function(){
                var owl = $('.carruselRecents');

                owl.owlCarousel({
                    margin: 30,
                    nav: true,
                    loop: true,
                    dots: false,
                    lazyContent: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: 10000,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    responsive: {
                        0: {
                            items: 1
                        },
                        640: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 4
                        }
                    }
                });
            },2000);
        });
    </script>

    @parent

@stop
