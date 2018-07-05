@php isset($currentUser) && !empty($currentUser) ? $user = $currentUser->id : $user = 0; @endphp

<div class="iblock general-block15 pt-5 pb-5"
     data-blocksrc="general.block15">
    <div id="featured_recommmend" class="container">
        <div class="row">
            <div class="col">

                <ul class="nav nav-tabs border-primary border-3"
                    id="myTab"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           id="featured-tab"
                           data-toggle="tab"
                           href="#featured"
                           role="tab"
                           aria-controls="featured"
                           aria-selected="true">
                            {{trans('icommerce::common.featured_recommended.featured')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="recommended-tab"
                           data-toggle="tab"
                           href="#recommended"
                           role="tab"
                           aria-controls="recommended"
                           aria-selected="false">
                            {{trans('icommerce::common.featured_recommended.recommended')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content pt-2"
                     id="myTabContent">
                    <!-- FEATURED -->
                    <div class="tab-pane fade show active"
                         id="featured"
                         role="tabpanel"
                         aria-labelledby="featured-tab">

                        <!-- carrousel -->
                        <div class="owl-carousel owl-theme carrousel_featured">
                            <!-- product -->
                            <div class="item" v-for="product in products_featured">
                                <div class="card card-product rounded-0 mt-4">
                                    <img v-if="item.freeshipping == 1" class="card-img-type" src="{{ Theme::url('img/free.png') }}" alt="">
                                    <div class="img-overlay">
                                        <!-- image -->
                                        <div class="card-img-top rounded-0 background_image"
                                             v-bind:style="{'background-image' : 'url(' +product.mainimage+ ')'}">
                                        </div>

                                        <div class="overlay">
                                            <div class="link">
                                                <a v-bind:href="product.url"
                                                   class="btn btn-outline-light">
                                                    {{trans('icommerce::common.featured_recommended.quick_view')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- title -->
                                        <h6 class="card-title text-center">
                                            <a v-bind:href="product.url">
                                                @{{ product.title }}
                                            </a>
                                        </h6>
                                        <!-- price -->
                                        <div class="row justify-content-md-center mb-2">
                                            <div class="col-md-auto">
                                                <p class="text-center font-weight-bold mb-1">
                                                    <del class="text-muted pr-2"
                                                         v-if="product.price_discount"
                                                         style="font-size: 14px">
                                                        $ @{{ product.price }}
                                                    </del>
                                                    <span class="text-danger font-weight-bold"
                                                          v-if="!product.price_discount">
                                                        $ @{{ product.price }}
                                                    </span>
                                                    <span class="text-danger font-weight-bold"
                                                          v-if="product.price_discount">
                                                        $ @{{ product.price_discount }}
                                                    </span>
                                                <hr class=" border-primary mt-0 mx-auto mb-4 w-75 border-2">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <a class="btn btn-outline-secondary"
                                               v-on:click="addCart(product)">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary"
                                               v-on:click="addWishList(product)">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <a v-bind:href="product.url"
                                               class="btn btn-outline-secondary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RECOMMEND -->
                    <div class="tab-pane fade"
                         id="recommended"
                         role="tabpanel"
                         aria-labelledby="recommended-tab">
                        <!-- carrousel -->
                        <div class="owl-carousel owl-theme carrousel_recommend">
                            <!-- product -->
                            <div class="item" v-for="product in products_recommend">
                                <div class="card card-product rounded-0 mt-4">
                                    <div class="img-overlay">
                                        <!-- image -->
                                        <div class="card-img-top rounded-0 background_image"
                                             v-bind:style="{'background-image' : 'url(' +product.mainimage+ ')'}">
                                        </div>

                                        <div class="overlay">
                                            <div class="link">
                                                <a v-bind:href="product.url"
                                                   class="btn btn-outline-light">
                                                    {{trans('icommerce::common.featured_recommended.quick_view')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- title -->
                                        <h6 class="card-title text-center">
                                            <a v-bind:href="product.url">
                                                @{{ product.title }}
                                            </a>
                                        </h6>
                                        <!-- price -->
                                        <div class="row justify-content-md-center mb-2">
                                            <div class="col-md-auto">
                                                <p class="text-center font-weight-bold mb-1">
                                                    <del class="text-muted pr-2"
                                                         v-if="product.price_discount"
                                                         style="font-size: 14px">
                                                        $ @{{ product.price }}
                                                    </del>
                                                    <span class="text-danger font-weight-bold"
                                                          v-if="!product.price_discount">
                                                        $ @{{ product.price }}
                                                    </span>
                                                    <span class="text-danger font-weight-bold"
                                                          v-if="product.price_discount">
                                                        $ @{{ product.price_discount }}
                                                    </span>
                                                <hr class=" border-primary mt-0 mx-auto mb-4 w-75 border-2">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <a class="btn btn-outline-secondary"
                                               v-on:click="addCart(product)">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary"
                                               v-on:click="addWishList(product)">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <a v-bind:href="product.url"
                                               class="btn btn-outline-secondary">
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
    </div>
</div>
</div>


@section('scripts-owl')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>


    <script>
        var vue_featured_recommmend = new Vue({
            el: '#featured_recommmend',
            created: function () {
                this.get_articles();
                this.get_wishlist();
            },
            data: {
                products_featured: '',
                products_recommend: '',
                user: {{ $user }},
                products_wishlist: [],
            },
            methods: {
                get_articles: function () {
                    axios.get('{{ route("icommerce.api.products.detals",335) }}')
                        .then(function(response){
                            vue_featured_recommmend.products_featured = response.data.data;
                        });
                    axios.get('{{ route("icommerce.api.products.detals",334) }}')
                        .then(function(response){
                            vue_featured_recommmend.products_recommend = response.data.data;
                        });
                },
                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                    data['quantity_cart'] = 1;
                    data = [data];

                    axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function(response){
                        if(response.data.status){
                            vue_featured_recommmend.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_carting.get_articles();
                        }else{
                            vue_featured_recommmend.alerta(
                                "{{trans('icommerce::products.alerts.no_add_cart')}}",
                                "error");
                        }
                    });
                },

                /* products wishlist */
                get_wishlist: function () {
                    if (this.user) {
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: '{{ route("icommerce.api.wishlist.user") }}?id='+this.user
                        }).then(function(response) {
                            vue_featured_recommmend.products_wishlist = response.data;
                        })
                    }
                },

                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                        if (!this.check_wisht_list(item.id)) {
                            var data = {
                                user_id: this.user,
                                product_id: item.id
                            };

                            axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function(response){
                                vue_featured_recommmend.get_wishlist();
                                vue_featured_recommmend.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
                            })
                        }else{
                            this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist')}}", "warning");
                        }
                    }
                    else {
                        this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
                    }
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function(id){
                    var list = this.products_wishlist;
                    var response = false;

                    $.each(list,function(index,item){
                        id === item.id ? response = true : false;
                    });

                    return response;
                },

                alerta: function (menssage, type) {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr[type](menssage);
                }
            }
        });

        $(document).ready(function(){
            var owlc = $('.carrousel_featured, .carrousel_recommend');

            owlc.owlCarousel({
                margin: 10,
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
                        items: 2
                    },
                    992: {
                        items: 4
                    }
                }
            });

        });
    </script>

    @parent

@stop