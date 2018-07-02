<div id="wishlist">
    <h6 class="pt-4 mb-3 text-secondary">
        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
        MY WISH LIST
    </h6>

    <h5 class="dropdown-header mb-0 font-weight-bold text-center"
        v-show="products_wishlist.length == 0" style="max-width: 90%;">
        You have no items in your wish list.
    </h5>
    <!--Shopping cart items-->

    <div id="product_date" class="owl-carousel owl-theme carruselweek">
        <div class="item" v-for="(item, index) in products_wishlist">

            <div class="cart-items px-3" v-for="k in 3">
                <div class="cart-items-item row" v-if="index < products_wishlist.length">

                    <a v-bind:href="products_wishlist[index].url"
                       class="cart-img mr-2 float-left col-4">
                        <img class="img-fluid"
                             v-bind:src="products_wishlist[index].mainimage"
                             v-bind:alt="products_wishlist[index].title">
                    </a>


                    <div class="float-left col-7">
                        <div class="row">

                            <h6 class="mb-0 w-100">
                                <a v-bind:href="products_wishlist[index].url">
                                    @{{ products_wishlist[index].title }}
                                </a>
                            </h6>

                            <p class="mb-0" style="font-size: 10px">
                                $ @{{ products_wishlist[index].price }}
                            </p>
                        </div>
                    </div>
                    <a class="close cart-remove text-primary" >
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <!--
            <div class="card card-product rounded-0 mt-4">
                <div class="img-overlay" >
                    <img class="card-img-top rounded-0" v-bind:src="item.mainimage"
                         alt="item.title">

                    <div class="overlay">
                        <div class="link">
                            <a v-bind:href="item.slug" class="btn btn-outline-light">QUICK VIEW</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h6 class="card-title text-center">
                        <a v-bind:href="item.slug">
                            @{{ item.title }}
                        </a>
                    </h6>

                    <div class="row justify-content-md-center">
                        <div class="col-6 col-md-auto">
                            <p class="text-center text-danger font-weight-bold mb-1">
                                $ @{{ item.price }}
                            </p>
                            <hr class=" border-primary mb-4 mt-0 w-50 border-2">
                        </div>

                    </div>


                    <div class="text-center">

                        <a v-bind:href="item.slug" class="btn btn-outline-secondary"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>

    <!--
    <div class="owl-carousel owl-theme carruselVertical carruselnewsVertical owl-loaded owl-drag">
        <div class="owl-stage-outer">
            <div class="owl-stage">
                <div class="owl-item cloned">
                    <div class="cart-items px-3" v-for="item in products_wishlist">

                        <div class="cart-items-item row">

                            <a v-bind:href="item.url"
                               class="cart-img mr-2 float-left col-3">
                                <img class="img-fluid"
                                     v-bind:src="item.mainimage"
                                     v-bind:alt="item.title">
                            </a>


                            <div class="float-left col-7">
                                <div class="row">

                                    <h6 class="mb-0 w-100">
                                        <a v-bind:href="item.url">
                                            @{{ item.title }}
                                        </a>
                                    </h6>

                                    <p class="mb-0" style="font-size: 10px">
                                        $ @{{ item.price }}
                                    </p>
                                </div>
                            </div>
                            <a class="close cart-remove text-primary" >
                                <i class="fa fa-times"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="owl-nav">
                <button type="button" role="presentation" class="owl-prev">
                    <i class="fa fa-angle-left"></i>
                </button>
                <button type="button" role="presentation" class="owl-next">
                    <i class="fa fa-angle-right"></i>
                </button>
            </div>
        </div>

    </div>
    -->
</div>

@section('scripts-owl')
    <script>
        $(document).ready(function(){
            var owl = $('.carruselweek');

            owl.owlCarousel({
                margin: 20,
                nav: true,
                loop: true,
                dots: false,
                lazyContent: true,
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 10000,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 1
                    },
                    992: {
                        items: 2
                    }
                }
            });

        });
    </script>

    @parent

@stop

