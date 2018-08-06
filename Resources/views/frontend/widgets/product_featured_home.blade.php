<!-- Usar $type para armar la consulta -->

<div class="carrusellist" id="contentProductsFeatured">
    <vuecarousel @add-cart="addCart" @add-wishlist="addWishList" :categories="1" :take="10" ></vuecarousel>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">
        var contentProductFeatured = new Vue({
            el: '#contentProductsFeatured',
            created: function () {
                console.log('product_featured');
                //this.getArticle();
                //this.getArticle();
                this.language = '{{ locale() }}';
            },
            data: {
                language: '',
                objects: []
            },
            methods: {
        {{--    getArticle: function () {
                    axios.get('{{ url("api/icommerce/products_featured") }}')
                        .then(response => {
                        console.log(response.data);
                        for (var i = 0; i < response.data.items.data.length; i++) {
                            response.data.items.data[i].cantidad = 1;
                        }
                        this.objects = response.data.items.data;
                    });
                },--}}
                addCart: function (item) {
                    item.cantidad = 1;
                    axios.post('{{ url("api/icommerce/add_cart") }}', item).then(response => {
                        console.log(response);
                        carting.articulos = response.data.items;
                        carting.cantidad = response.data.cantidad;
                        carting.updatePrecio(response.data.items);

                        this.alerta("{{trans('icommerce::cart.message.add')}}", "success");
                    }).
                        catch(error => {
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
            }
        });

    </script>

@stop
