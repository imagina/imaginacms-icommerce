@if($currentUser)

    <div id="wishlist" v-if="products_wishlist.length >= 1">

        <div class="card border-0 card-items mb-3">
            <div class="card-header bg-primary  py-2 px-3 text-white">
             {{trans('icommerce::wishlists.owl_whishlist.title')}}
            </div>
        </div>

        <div id="carrusel-wishlist" class="owl-carousel owl-theme carruselWishlist" data-ride="carousel-wishlist">

            <div class="item" v-for="product in products_wishlist">
                <div v-for="item in product">

                    <div class="row pb-4 no-gutters card-product align-items-center">

                        <div class="col-5 pr-3">

                                <a v-bind:href="item.url">
                                    <div class="img-vertical border rounded-lg p-1">
                                        <img class="rounded-lg img-fluid w-100" v-bind:src="item.mainimage">
                                    </div>
                                </a>

                        </div>

                        <div class="content col-7">

                            <h6 class="card-title mb-0">
                                <a v-bind:href="item.url">
                                 <small> @{{ item.title}} </small>
                                </a>
                            </h6>

                            <h6 class="text-primary price font-weight-bold">
                              <small>  $ @{{ item.price }}</small>
                            </h6>

                            <div class="buttons mt-2">

                                <a class="btn btn-secondary bg-secondary rounded-0 btn-sm border-0"
                                   v-on:click="addCart(item)">
                                    <i class="fa fa-shopping-cart text-white"></i>
                                </a>

                                <a class="btn btn-outline-primary rounded-0 btn-sm border-0"
                                   v-on:click="deleteWishList(item)">
                                    <i class="fa fa-trash-o " aria-hidden="true"></i>
                                </a>

                            </div>
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