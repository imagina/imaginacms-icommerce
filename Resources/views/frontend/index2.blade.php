@extends('layouts.master')
@include('icommerce::frontend.partials.carting')

@section('content')
    <div id="content_index_commerce"
         class="page"
         data-icontenttype="page"
         data-icontentid="2">

        <!-- ===== PAGINATE ====== -->
        <div class="iblock general-block21" data-blocksrc="general.block21">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-4 text-uppercase">
                                <li class="breadcrumb-item"><a href="#">{{trans('icommerce::common.home.title')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>
        </div>

        <!-- ======== @Region: #content ======== -->
        <div class="iblock general-block22" data-blocksrc="general.block22">
            <div class="container">
                <div class="row">

                    <!-- ===== SIDEBAR_RIGHT ===== -->
                    <!-- BARRA LATERAL IZQUIERDA -->
                    <div id="sidebar_right"
                         class="col-md-4 col-lg-3 order-sm-1 order-md-0 pb-4">
                        <!-- categorias -->
                        @include('icommerce.widgets.categories')

                        <!-- manufacturer -->
                        @include('icommerce.widgets.manufacturers')

                        <!-- rango de precio -->
                        @include('icommerce.widgets.range_price')

                        <!-- wishlist -->
                        @include('icommerce.widgets.wishlist')

                        <h6 class="pt-4 mb-3 text-secondary">
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            {{trans('icommerce::common.related.page')}}
                        </h6>
                        <p class="m-0 pl-2 text-justify">{{trans('icommerce::common.related.unknown')}}</p>
                        <p class="m-0 pl-2 text-justify">{{trans('icommerce::common.related.unknown')}}</p>
                    </div>

                    <!-- ===== CONTENT ===== -->
                    <div id="content"
                         class="col-md-8 col-lg-9 order-sm-0 order-md-1 pb-3">

                        <!-- CATEGORY  -->
                        <h1 class="text-info">
                            {{$category->title}}
                        </h1>
                        {!!$category->description!!}

                        <!-- BANNER CATEGORY -->
                        @include('partials.widgets.banner-category')

                        <!-- ORDER BY -->
                        <div class="w-100">
                            @include('icommerce.widgets.order_by')
                        </div>

                        <!-- PRODUCTS -->
                        <div id="cont_products" class="w-100 mt-4">
                            @include('icommerce.widgets.products')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const vue_index_commerce = new Vue({
            el: '#content_index_commerce',
            data: {
                /*paginador*/
                pages: 0,
                p_currence: 1,
                articles: [],
                path: '{{ route('icommerce.api.products.category',[$category ? $category->id : 0]) }}',
                criterion: '{{ isset($criterion) ? $criterion : ''}}',
                /*filtros*/
                price: false,
                manufacturer: false,
                order: {
                    by: 'created_at',
                    type: 'DESC'
                },
                /*order*/
                order_check: 'all',
                /*manufacturer*/
                products_manufacturer: [],
                /*rango de precio*/
                min_price: 0,
                max_price: 0,
                v_max: false,
                v_min: false,
                /*currency*/
                currency: '$',
            },
            methods: {
                /*obtiene los productos */
                get_products: function (path) {
                    !path ? path = this.path : false;

                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: path,
                        params: {
                            order: this.order,
                            price: this.price,
                            manufacturer: this.manufacturer,
                            criterion: this.criterion
                        }
                    }).then(response=>{
                        this.order_response(response);
                    });
                },

                /*ordena los datos luego de consultar los productos*/
                order_response: function (response) {
                    this.articles = response.data.products;
                    //guarda los manufactures
                    if (this.products_manufacturer.length === 0) {
                        this.products_manufacturer = response.data.manufacturer;
                    }
                    /*paginador*/
                    this.p_currence = response.data.paginate.current_page;
                    this.pages = response.data.paginate.last_page;
                    /*rango de precio*/
                    if (!this.min_price || !this.max_price) {
                        this.min_price = parseInt(response.data.range_price.min_price);
                        this.max_price = parseInt(response.data.range_price.max_price);
                    }
                    /*currency*/
                    this.currency = response.data.currency;
                    this.range_price();
                },

                /*cambia la pagina de los productos*/
                change_page: function (page, btn) {
                    !page ? page = this.p_currence : false;

                    btn === 'next' ? page = page + 1 :
                        btn === 'previous' ? page = page - 1 : false;

                    var path = this.path + '?page=' + page;
                    this.get_products(path);
                },

                /*configura la consulta por order by*/
                order_by: function () {
                    switch (this.order_check) {
                        case 'all' :
                            this.order.by = 'created_at';
                            this.order.type = 'desc';
                            break;
                        case 'rating' :
                            this.order.by = 'rating';
                            this.order.type = 'desc';
                            break;
                        case 'nameaz' :
                            this.order.by = 'slug';
                            this.order.type = 'asc';
                            break;
                        case 'nameza' :
                            this.order.by = 'slug';
                            this.order.type = 'desc';
                            break;
                        case 'lowerprice' :
                            this.order.by = 'price';
                            this.order.type = 'asc';
                            break;
                        case 'higherprice' :
                            this.order.by = 'price';
                            this.order.type = 'desc';
                            break;
                    }

                    this.get_products();
                },

                /*configura el rango de precio*/
                range_price: function () {
                    var s_slider = $("#slider-range");
                    var min = this.min_price;
                    var max = this.max_price;

                    if (this.v_max) {
                        this.v_min = s_slider.slider("values", 0);
                        this.v_max = s_slider.slider("values", 1);
                        s_slider.slider("destroy");
                    } else {
                        this.v_max = max;
                        this.v_min = min;
                    }

                    var v_max = this.v_max;
                    var v_min = this.v_min;


                    s_slider.slider({
                        range: true,
                        min: min,
                        max: max,
                        values: [v_min, v_max],
                        slide: function (event, ui) {
                            $("#amount").text("$ " + ui.values[0] + " - $ " + ui.values[1]);
                        },
                        create: function (event, ui) {
                            $("#amount").text("$ " + v_min + " - $ " + v_max);
                        },
                        change: function (event, ui) {
                            vue_index_commerce.filter_price(ui.values);
                        }
                    });
                },

                /* configuar la consulta por rango de precio */
                filter_price: function (values) {
                    this.price = {
                        min: values[0],
                        max: values[1]
                    };

                    this.get_products();
                },

                /*configura la consulta por manufacturer*/
                filter_manufacturer: function (id) {
                    id ? this.manufacturer = id : this.manufacturer = false;
                    this.get_products();
                },

                /*agrega el producto al carro de compras*/
                addCart: function (item) {
                    item.quantity = 1;

                    axios.post('{{ url("api/icommerce/add_cart") }}', item).then(response => {
                        if(response.data.status){
                            this.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_carting.get_articles();
                        }else{
                            this.alerta("{{trans('icommerce::products.alerts.no_add_cart')}}", "error");
                        }
                    }).catch(error => {
                        console.log(error);
                    });
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
                },
            },

            beforeMount: function () {
                this.get_products(this.path)
            }
        });
    </script>
@stop
