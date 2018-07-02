@php isset($currentUser) && !empty($currentUser) ? $user = $currentUser->id : $user = 0; @endphp

<div id="product_date" class="owl-carousel owl-theme carruselweek">

    <div class="item" v-for="item in articles">
        <div class="card card-product rounded-0 mt-4">
            <div class="img-overlay">
                <!-- image -->
                <div class="card-img-top rounded-0 background_image"
                     v-bind:style="{'background-image' : 'url(' +item.mainimage+ ')'}">
                </div>

                <div class="overlay">
                    <div class="link">
                        <a v-bind:href="item.url"
                           class="btn btn-outline-light">
                            QUICK VIEW
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h6 class="card-title text-center">
                    <a v-bind:href="item.url">
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
                    <a class="btn btn-outline-secondary"
                       v-on:click="addCart(item)">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                    <a class="btn btn-outline-secondary"
                       v-on:click="addWishList(item)">
                        <i class="fa fa-heart"></i>
                    </a>
                    <a v-bind:href="item.url"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script type="text/javascript">
        var vue_products_detals = new Vue({
            el: '#product_date',
            created: function () {
                this.get_articles();
                this.get_wishlist();
            },
            data: {
                articles: '',
                user: {{ $user }},
                products_wishlist: [],
            },
            methods: {
                get_articles: function () {
                    axios.get('{{ route("icommerce.api.products.detals",333) }}')
                        .then(function(response){
                            vue_products_detals.articles = response.data.data;
                        });
                },
                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                    data['quantity_cart'] = 1;
                    data = [data];

                    axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function(response){
                        if(response.data.status){
                            vue_products_detals.alerta("product added to the car", "success");
                            vue_carting.get_articles();
                        }else{
                            vue_products_detals.alerta(
                                "Can not add the product, try again please",
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
                            vue_products_detals.products_wishlist = response.data;
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
                                vue_products_detals.get_wishlist();
                                vue_products_detals.alerta("Product added to your wish list", "success");
                            })
                        }else{
                            this.alerta("This product is already on your wish list", "warning");
                        }
                    }
                    else {
                        this.alerta("Debes estar logeado", "warning");
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
    </script>

@stop

@section('scripts-owl')
    <script>
        $(document).ready(function(){
            setTimeout(function(){
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
            },2000);
        });
    </script>

    @parent

@stop