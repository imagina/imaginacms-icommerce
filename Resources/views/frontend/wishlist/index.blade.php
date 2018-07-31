@extends('layouts.master')

@section('content')
    <!-- preloader -->
    <div id="content_preloader"><div id="preloader"></div></div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('icommerce::common.home.title')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{trans('icommerce::wishlists.title.wishlists')}}</li>
                        </ol>
                    </nav>

                    <h2 class="text-center mt-0 mb-5">{{trans('icommerce::wishlists.title.my_wishlists')}}</h2>

                </div>
            </div>
        </div>
    </div>

    <!-- ======== @Region: #content ======== -->
    <div id="wishlist" class="pb-5">

        <div class="container">
            <!-- Shopping cart -->
            <div class="cart-content" v-show="items.length > 0">
                <div class="wrapper-cart-table">
                    <!--Shopping cart items-->
                    <table class="table table-responsive mb-0 cart-table">
                        <thead>
                        <tr>
                            <th class="w-10 text-center"></th>
                            <th class="w-15 text-center">{{trans('icommerce::cart.table.picture')}}</th>
                            <th class="w-35 text-center">{{trans('icommerce::cart.table.item')}}</th>
                            <th class="w-25 text-center">{{trans('icommerce::cart.table.unit_price')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Cart item 1 -->
                        <tr v-for="(item, index) in items">
                            <td class="text-center align-middle">
                                <a class="close cart-remove" v-on:click="deleteItem(item, index)">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a v-bind:href="item.url" >
                                    <img class="cart-img img-fluid" v-bind:src="item.mainimage" v-bind:alt="item.title">
                                </a>
                            </td>
                            <td>
                                <span class="font-weight-bold">
                                    <a v-bind:href="item.url">
                                        @{{ item.title }}
                                    </a>
                                </span>
                            </td>
                            <td class="text-center align-middle">$ @{{ item.price }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--End of Shopping cart items-->
                <hr class="my-4 hr-lg">
                <div class="cart-content-footer">
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-8 text-right mt-3 mt-md-0">
                            <div class="cart-content-totals">

                            </div>
                            <!-- Proceed to checkout -->
                            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">{{trans('icommerce::wishlists.button.continue_shopping')}}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="items.length == 0">
                <div class="col p-6">
                    {{trans('icommerce::wishlists.messages.no_item')}}
                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script type="text/javascript">
        const vue_my_wishlist = new Vue({
            el: '#wishlist',
            created: function () {

            },
            data: {
                items: [],
                user: {!! $user !!},
            },
            methods: {
                getMyWishlist: function () {
                    if (this.user) {
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: '{{ route("icommerce.api.wishlist.user") }}?id='+this.user
                        }).then(function(response) {
                            vue_my_wishlist.items = response.data;
                            console.log(response.data);
                        })
                    }
                },
                deleteItem: function (item, index) {
                    var aux = {
                        user_id: this.user,
                        product_id: item.id
                    };
                    axios.post('{{ route("icommerce.api.wishlist.delete") }}', aux)
                        .then(response => {
                        //this.items = response.data.items;
                        vue_my_wishlist.items.splice(index, 1);

                    this.alerta("{{trans('icommerce::wishlists.alerts.delete')}}", "success");
                }).catch(error => {
                        console.log(error);
                });
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
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getMyWishlist();
                    setTimeout(function(){
                        $('#content_preloader').fadeOut(1000,function(){
                            $('#content_index_commerce').animate({'opacity':1},500);
                        });
                    },1800);
                })
            }
        });
    </script>
@stop