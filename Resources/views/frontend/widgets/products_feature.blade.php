<div id="contentProductsFeatured" class="iblock general-block33" data-blocksrc="general.block33">
    <section class="iblock general-block15 pb-5" data-blocksrc="general.block15">
        <div class="container">
            <div class="row">

                <div class="col-12">

                    <div class="title-1 mb-4 mt-4">
                        <div class="d-inline-block">
                            <h3 class="font-weight-bold d-inline-block px-4 pt-2">
                                {{trans('icommerce::products.related')}}
                            </h3>
                            <hr class="border-primary border-2 mb-0">
                            <hr class="border-secondary w-10 border-2 mb-0">
                        </div>
                    </div>

                    <!-- carrousel -->
                    <div id="carrusel-recents"
                         class="owl-carousel owl-theme carruselPro carruselPro2 carruselRecents"
                         data-ride="carousel-recents">

                        <!-- product -->
                        <div class="item card-product" v-for="item in related_products">
                            <!-- PRODUCT -->
                            <div class="card card-product rounded-0 mb-4">
                                <!-- image -->
                                <div class="img-overlay">
                                    <img class="card-img-top rounded-0"
                                         v-bind:src="item.mainimage"
                                         v-bind:alt="item.title"
                                         alt="Card image cap">
                                    <img v-if="item.discounts" class="card-img-type"
                                         src="{{ Theme::url('img/sale.png') }}" alt="">
                                    <div class="overlay">
                                        <div class="link">
                                            <a v-bind:href="item.url"
                                               class="btn btn-outline-light">
                                                {{trans('icommerce::common.featured_recommended.quick_view')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- dates product -->
                                <div class="card-body">
                                    <!-- title -->
                                    <h6 class="card-title text-center font-weight-bold">
                                        <a v-bind:href="item.url">
                                            @{{ item.title}}
                                        </a>
                                    </h6>

                                    <!-- precio del producto -->
                                    <div class="row justify-content-md-center mb-2">
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
                                                <hr class=" border-primary mt-0 mx-auto mb-4 w-75 border-2">
                                            </p>
                                        </div>
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
    </section>
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
