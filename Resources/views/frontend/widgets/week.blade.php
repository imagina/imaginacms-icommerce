@php isset($currentUser) && !empty($currentUser) ? $user = $currentUser->id : $user = 0; @endphp

<div id="product_date" class="carruselweek">
    <vuecarousel @add-cart="addCart" @add-wishlist="addWishList" :categories="'[201,265]'" :take="10"></vuecarousel>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">
        var vue_products_detals = new Vue({
            el: '#product_date',
            created: function () {
                {{--  this.get_articles();--}}
                this.get_wishlist();
            },
            data: {
                articles: '',
                user: {{ $user }},
                products_wishlist: [],
            },
            methods: {
        {{--   get_articles: function () {
                    axios.get('{{ route("icommerce.api.products.detals",333) }}')
                        .then(function(response){
                            vue_products_detals.articles = response.data.data;
                        });
                },--}}
                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                    data['quantity_cart'] = 1;
                    data = [data];

                    axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function(response){
                        if(response.data.status){
                            vue_products_detals.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_carting.get_articles();
                        }else{
                            vue_products_detals.alerta(
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
                                vue_products_detals.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
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
    </script>

@stop

