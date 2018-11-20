@if($currentUser)

    <div id="wishlist" v-if="products_wishlist.length >= 1">

        <h6 class="pt-4 mb-3 text-secondary">
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            {{trans('icommerce::wishlists.owl_whishlist.title')}}
        </h6>

        <div id="carrusel-wishlist" class="owl-carousel owl-theme carruselWishlist" data-ride="carousel-wishlist">

            <div class="item" v-for="product in products_wishlist">
                <div v-for="item in product">

                    <div class="row py-3">

                        <div class="col-lg-4 pr-0">
                            <a href="#">
                                {{-- <a v-bind:href="item.url"> --}}
                                <div class="content-img border">

                                    <img v-if="item.mainimage != null"
                                         class="img-fluid p-1"
                                         v-bind:src="item.mainimage"
                                         v-bind:alt="item.title">

                                    <img v-else class="img-fluid"
                                         src="http://local.imagina.com.co:82/labs/appstrap3.0.11/theme/assets/img/shop/gloves-1-thumb.jpg"
                                         v-bind:alt="item.title">
                                </div>
                            </a>
                        </div>

                        <div class="content col-lg-8">
                            <h6>
                                <a href="#" class="text-muted">
                                    <small> @{{ item.title }} </small>
                                </a>
                            </h6>

                            <h6 class="text-primary price font-weight-bold mt-2">
                                $ @{{ item.price }}
                            </h6>
                        </div>

                        <div class="buttons text-center col-12 mt-1">

                            <a class="btn btn-outline-primary btn-sm"
                               v-on:click="addCart(item)">
                                <i class="fa fa-shopping-cart text-danger"></i>
                            </a>

                            <a v-bind:href="item.url"
                               class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a class="btn btn-outline-primary btn-sm"
                               v-on:click="deleteWishList(item)">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

@section('scripts-owl')
    @parent
    <script>
        $(document).ready(function () {
            var owl = $('.carruselWishlist');

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
                        items: 1
                    },
                    992: {
                        items: 1
                    }
                }
            });
        });
    </script>
@stop

@endif