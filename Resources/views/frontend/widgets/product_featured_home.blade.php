<!-- Usar $type para armar la consulta -->


<div class="owl-carousel owl-theme carrusellist" id="contentProductsFeatured">
    <div class="item" v-for="item in objects">
        <div class="card card-product rounded-0 mt-4">
            <div class="img-overlay">
                <!--
                <img class="card-img-top rounded-0" src="{{ Theme::url('img/producto1.jpg') }}"
                     alt="Card image cap">
                     -->
                <img v-if="item.options.mainimage != null" class="card-img-top rounded-0" v-bind:src="item.options.mainimage"
                     alt="item.title[language]">
                <img v-else class="card-img-top rounded-0" src="{{url('modules/bcrud/img/default.jpg')}}"
                     alt="item.title[language]">
                <!--
                <img class="card-img-type" src="{{ Theme::url('img/sale.png') }}" alt="">
                -->
                <div class="overlay">
                    <div class="link">
                        <a v-bind:href="item.slug" class="btn btn-outline-light">{{trans('icommerce::common.featured_recommended.quick_view')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="card-title text-center">
                    <a v-bind:href="item.slug">
                        @{{ item.title[language] }}
                    </a>
                </h6>
                <div class="row justify-content-md-center">
                    <div class="col-6 col-md-auto">
                        <p class="text-center text-danger font-weight-bold mb-1">
                            $ @{{ item.price }}
                        </p>
                        <hr class=" border-primary mb-4 mt-0 w-50 border-2">
                    </div>
                    <!--
                    <div class="col-6 col-md-auto">
                        <p class="text-center text-danger font-weight-bold text-through">$808.90</p>
                    </div>
                    -->
                </div>
                <div class="text-center">
                    <a class="btn btn-outline-secondary" v-on:click="addCart(item)"><i class="fa fa-shopping-cart"></i></a>
                    <!--<a href="" class="btn btn-outline-secondary"><i class="fa fa-heart"></i></a>-->
                    <a v-bind:href="item.slug" class="btn btn-outline-secondary"><i class="fa fa-eye"></i></a>
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
        var contentProductFeatured = new Vue({
            el: '#contentProductsFeatured',
            created: function () {
                console.log('product_featured');
                //this.getArticle();
                this.getArticle();
                this.language = '{{ locale() }}';
            },
            data: {
                language: '',
                objects: []
            },
            methods: {
                getArticle: function () {
                    axios.get('{{ url("api/icommerce/products_featured") }}')
                        .then(response => {
                        console.log(response.data);
                        for (var i = 0; i < response.data.items.data.length; i++) {
                            response.data.items.data[i].cantidad = 1;
                        }
                        this.objects = response.data.items.data;
                    });
                },
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

@section('scripts-owl')
    <script>
        $(document).ready(function(){
            var owlc = $('.carrusellist');

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
