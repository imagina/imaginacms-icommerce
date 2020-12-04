<section id="featuredpreferidos" class="iblock general-block13 py-5" data-blocksrc="general.block13">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text-title text-center mb-4">
                    <h2 class="title">
                        Nuestros Preferidos
                    </h2>
                    <h6 class="subtitle">
                        ¡Agrega a tu lista nuestros preferidos y hazlos los tuyos también!
                    </h6>
                </div>
                <featured  @add-cart="addCart" @add-wishlist="addWishList" :categories="39" :take="8"></featured>
            </div>
        </div>
    </div>
</section>


@section('scripts')
    @parent

    <script>
        const featuredpreferidos = new Vue({
            el: '#featuredpreferidos',
            data: {
                currency: false,
                loading: true,
                user: {!! $currentUser ? $currentUser->id : 0 !!},
                products_wishlist:[],
            },
            methods: {
                /*agrega el producto al carro de compras*/
                addCart: function (item) {
                    vue_carting.addItemCart(item.id,item.name,item.price);
                },
                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                        let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                        if (!this.check_wisht_list(item.id)) {
                            axios.post("{{url('/')}}"+"/api/icommerce/v3/wishlists", {
                                attributes:{
                                    user_id: this.user,
                                    product_id: item.id
                                }
                            },{
                                headers:{
                                    'Authorization':token
                                }
                            }).then(response => {
                                this.get_wishlist();
                                this.alerta("producto agregado a la lista", "success");
                            })
                        } else {
                            this.alerta("Producto en la lista", "warning");
                        }
                    }
                    else {
                        this.alerta("Por Favor, Inicie Sesion", "warning");
                    }
                },
                /* products wishlist */
                get_wishlist: function () {
                    let url="{{url('api/icommerce/v3/wishlists')}}";
                    if (this.user) {
                        let token="Bearer "+"{!! $currentUser ? $currentUser->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: url+'?filter={' + this.user+'}',
                            headers:{
                                'Authorization':token
                            }
                        }).then(response => {
                            this.products_wishlist = response.data.data;
                        })
                    }
                },
                /*check if exist product in wisthlist*/
                check_wisht_list: function (id) {
                    var response = false;
                    $.each(this.products_wishlist, function (index, item) {
                        if ( id==item.product_id) {
                            response = true;
                        }
                    });
                    return response;
                },
                /*alertas*/
                alerta: function (menssage, type) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 400,
                        "hideDuration": 400,
                        "timeOut": 4000,
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
