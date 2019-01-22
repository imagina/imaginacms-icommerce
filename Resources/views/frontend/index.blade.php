@extends('layouts.master')

@section('meta')
    @if(isset($category) && !empty($category))
        <meta name="description" content="{{$category->options->metadescription ?? $category->description ?? ''}}">
        <!-- Schema.org para Google+ -->
        <meta itemprop="name" content="{{$category->options->metatitle ?? $category->title ?? ''}}">
        <meta itemprop="description" content="{{$category->options->metadescription ?? $category->description ?? ''}}">
        <meta itemprop="image"
              content=" {{url($category->options->mainimage??'modules/icommerce/img/category/default.jpg')}}">
    @endif
@stop
@section('title')
    {{isset($category->title)? $category->title: 'search'}}  | @parent
@stop


@section('content')
    <!-- preloader -->
    <div id="content_preloader">
        <div id="preloader"></div>
    </div>

    <div id="content_index_commerce"
         class="page"
         style="opacity: 0"
         data-icontenttype="page"
         data-icontentid="2">

    @if(isset($category) && !empty($category))
        <!-- ===== PAGINATE ====== -->
            <div class="iblock general-block21" data-blocksrc="general.block21">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mt-4 text-uppercase">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}">{{trans('icommerce::common.home.title')}}</a>
                                    </li>
                                    @if(isset($category->parent) && !empty($category->parent))
                                        <li class="breadcrumb-item">
                                            <a href="{{ $category->parent->url }}">
                                                {{ $category->parent->title }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="breadcrumb-item active"
                                        aria-current="page">
                                        {{$category->title}}
                                    </li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pt-5">
                <h4 class="text-center">
                    <span class="text-muted">
                     {{trans('icommerce::common.search.search_result')}}
                    </span>
                    <span class="text-primary font-weight-bold">
                        "{{ isset($criterion) ? $criterion : ''}}"
                    </span>
                </h4>
            </div>
    @endif

    <!-- ======== @Region: #content ======== -->
        <div id="content-primary"
             class="iblock general-block22"
             data-blocksrc="general.block22">
            <div class="container">
                <div class="row">

                    <!-- ===== SIDEBAR_RIGHT ===== -->
                    <!-- BARRA LATERAL IZQUIERDA -->
                    <div id="sidebar_right"
                         class="col-md-4 col-lg-3 order-sm-1 order-md-0 pb-4">
                        <!-- categorias -->
                    @include('icommerce::frontend.widgets.categories')

                    <!-- filter option: example: size,color -->
                    @include('icommerce::frontend.widgets.filter_general')

                    <!-- manufacturer -->
                    @include('icommerce::frontend.widgets.manufacturers')

                    <!-- rango de precio -->
                    @include('icommerce::frontend.widgets.range_price')

                    <!-- wishlist -->
                        @include('icommerce::frontend.widgets.owlwishlist')

                        {{--<h6 class="pt-4 mb-3 text-secondary">
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            RELATED PAGE
                        </h6>
                        @menu('related-page')--}}
                    </div>

                    <!-- ===== CONTENT ===== -->
                    <div id="content"
                         class="col-md-8 col-lg-9 order-sm-0 order-md-1 pb-3">

                    @if(isset($category) && !empty($category))
                        <!-- CATEGORY  -->
                            <h1 class="text-info">
                                {{$category->title}}
                            </h1>
                        {!!$category->description!!}

                        <!-- BANNER CATEGORY -->
                        {{--@include('partials.widgets.banner-category')--}}
                    @endif

                    <!-- ORDER BY -->
                        <div class="col-12 p-0">
                            @include('icommerce::frontend.widgets.order_by')
                        </div>

                        <!-- PRODUCTS -->
                        <div id="cont_products" class="col-12 p-0 mt-4">
                            @include('icommerce::frontend.widgets.products')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    @parent
    <script>
        /* =========== VUE ========== */
        const vue_index_commerce = new Vue({
            el: '#content_index_commerce',
            data: {
                /*paginador*/
                pages: 0,
                preloaded: true,
                p_currence: 1,
                currencySymbolLeft: icommerce.currencySymbolLeft,
                currencySymbolRight: icommerce.currencySymbolRight,
                v_pages: 5,
                r_pages: {
                    first: 1,
                    latest: 5
                },
                /*dates*/
                articles: [],
                products_wishlist: [],
                path: '{{route("icommerce.api.products")}}',
                user: {!! !empty($user)? $user :0 !!},
                currency: '$',
                /*order*/
                order_check: 'all',
                order: {
                    by: 'created_at',
                    type: 'DESC'
                },
                /*manufacturer*/
                products_manufacturer: [],
                /*rango de precio*/
                range_price: {
                    min_price: null,
                    max_price: null
                },
                options_anchos: [],
                options_perfil: [],
                options_rin: [],
                /*Filters !!!!!!!!!!!!!!!!!! */
                category_parent: {{$category->id}}, //CATEGORIA PADRE
                categories: {{ isset($_GET["categories"])? $_GET["categories"] : $category->id }}, //SUBCATEGORIAS
                manufacturers: "",
                paginate: 9,
                price: {
                    min: null,
                    max: null
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
                /*wishlist*/
                products_wishlist: [],
                user: {!! !empty($user)? $user :0 !!},
                /*currency*/
                currency: '$',
                preloader: true,
                options:[],
                options_selected:[],
                category:{!! $category ? $category : "''"  !!},
                options_values: {
                    ancho: {{ isset($_GET["ancho"])? $_GET["ancho"] : 'null' }},
                    rin: {{ isset($_GET["rin"])? $_GET["rin"] : 'null' }},
                    perfil: {{ isset($_GET["perfil"])? $_GET["perfil"] : 'null' }},
                },
            },
            created: function () {
                this.$nextTick(function () {
                    this.get_products(this.path);
                    this.get_wishlist();
                })
            },
            mounted: function () {
                this.preloaded = false;
                $('#content_preloader').fadeOut(1000, function () {
                    $('#content_index_commerce').animate({'opacity': 1}, 500);
                });
            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
                /*obtiene los productos */
                get_products: function (path) {
                    !path ? path = this.path : false;
                    this.preloaded = true;
                    var filters = {
                        categories: this.categories,
                        order: this.order,
                        paginate: this.paginate,
                        price: this.price,
                        options: this.options_values,
                    }
                    if (this.manufacturers) {
                        filters.manufacturers = [this.manufacturers]
                    }

                    axios({
                        method: 'GET',
                        responseType: 'json',
                        url: path,
                        params: {
                            filters
                        }
                    }).then(response => {
                        this.order_response(response);
                    });
                },

                /*obtiene las opciones de producto */
                get_options: function () {
                  if(this.category!=""){
                    axios({
                      method: 'Get',
                      responseType: 'json',
                      url: "{{ route('icommerce.api.options') }}",
                      params: {
                        filters:{
                          category_id:this.category.id
                          // withProducts:true
                        }
                      }
                    }).then(function (response) {
                      vue_index_commerce.options=response.data;
                    });
                  }//category !=""
                },
                /////Obtener valores de select de opciones
                getValues(e){
                  if(e.target.options.selectedIndex > -1) {
                    var optValueId=e.target.options[e.target.options.selectedIndex].value;
                    var optionDesc=e.target.options[e.target.options.selectedIndex].dataset.optiondesc;
                    var b=0;
                    for(var i=0;i<this.options_selected.length;i++){
                      if(this.options_selected[i].optionDesc==optionDesc){
                        this.options_selected[i].optionDesc=optionDesc;
                        this.options_selected[i].optValueId=optValueId;
                        b=1;//Found
                      }//if option desc selected
                    }//for options selected
                    if(b==0)
                      this.options_selected.push({'optionDesc':optionDesc,'optValueId':optValueId});
                  }//target options select
                },
                /* Buscar productos por filtro */
                searchProducts(){
                  // console.log(this.options_selected);
                  var filter={
                    order: this.order,
                    price: this.price,
                    manufacturer: this.manufacturer,
                    criterion: this.criterion,
                    categories:this.category.id
                  };
                  var option_values=[];
                  // console.log(option_values);
                  if(this.options_selected.length>0){
                    for(var i=0;i<this.options_selected.length;i++){
                      option_values.push(this.options_selected[i].optValueId);
                    }//for
                    filter.options_values=option_values;
                  }//if options_selected > 0
                  axios({
                    method: 'Get',
                    responseType: 'json',
                    url: "{{ route('icommerce.api.products') }}",
                    params: {
                      filter:filter
                    }
                  }).then(function (response) {
                    vue_index_commerce.order_response2(response);
                    //vue_index_commerce.articles=response.data.data;
                  });
                },
                //////Order response v2
                order_response2(response){
                  //console.log('Data response:');
                  //console.log(response);
                  /*productos*/
                  this.articles=response.data.data;
                  /*paginador*/
                  this.p_currence = response.data.meta.page.currentPage;
                  this.pages = response.data.meta.page.lastPage;

                },
                //////Order response v2
                /*Limpiar los filtros y traer todos los productos de la categoria*/
                clearAll(){
                  this.options_selected=[];
                  this.criterion= '{{ isset($criterion) ? $criterion : ''}}';
                  this.price= false;
                  this.manufacturer= false;
                  this.order= {
                    by: 'created_at',
                    type: 'DESC'
                  };
                  this.searchProducts();
                },

                /*ordena los datos luego de consultar los productos*/
                order_response: function (response) {
                    this.articles = response.data.data;
                    //guarda los manufactures
                    if (this.products_manufacturer.length === 0) {
                        this.products_manufacturer = response.data.manufacturer;
                    }
                    /*paginador*/
                    this.p_currence = response.data.links.self;
                    this.pages = response.data.links.last;

                    this.preloaded = false;
                },

                /*cambia la pagina de los productos*/
                change_page: function (page, btn) {
                    !page ? page = this.p_currence : false;
                    var last_page = this.r_pages.latest + 1;
                    var first_page = this.r_pages.first - 1;

                    if (btn === 'next') {
                        page = page + 1;
                        if (page > this.r_pages.latest) {
                            this.r_pages.first = last_page;
                            this.r_pages.latest += this.v_pages;
                        }
                    }

                    if (btn === 'previous') {
                        page = page - 1;
                        if (page < this.r_pages.first) {
                            this.r_pages.first -= this.v_pages;
                            this.r_pages.latest = first_page;
                        }
                    }

                    var path = this.path + '?page=' + page;
                    this.get_products(path);
                },

                /* configura la consulta por order by */
                order_by: function () {
                    switch (this.order_check) {
                        case 'all' :
                            this.order.by = 'created_at';
                            this.order.type = 'desc';
                            this.order = this.order
                            break;
                        case 'rating' :
                            this.order.by = 'rating';
                            this.order.type = 'desc';
                            this.order = this.order
                            break;
                        case 'nameaz' :
                            this.order.by = 'slug';
                            this.order.type = 'asc';
                            this.order = this.order
                            break;
                        case 'nameza' :
                            this.order.by = 'slug';
                            this.order.type = 'desc';
                            this.order = this.order
                            break;
                        case 'lowerprice' :
                            this.order.by = 'price';
                            this.order.type = 'asc';
                            this.order = this.order
                            break;
                        case 'higherprice' :
                            this.order.by = 'price';
                            this.order.type = 'desc';
                            this.order = this.order
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

                filter_categories: function (id) {
                    id ? this.categories = id : this.categories = false;
                    this.get_products();
                },

                /*agrega el producto al carro de compras*/
                addCart: function (item) {
                    item['quantity_cart'] = 1;
                    axios.post('{{ url("api/icommerce/add_cart") }}', [item]).then(response => {
                        if (response.data.status) {
                            this.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_carting.get_articles();
                        } else
                            this.alerta("{{trans('icommerce::products.alerts.no_add_cart')}}", "error");
                    }).catch(error => {
                        this.alerta("{{trans('icommerce::products.alerts.no_add_cart')}}", "error");
                        console.log(error);
                    });
                },

                /* products wishlist */
                get_wishlist: function () {
                    if (this.user) {
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: '{{ route("icommerce.api.wishlist.user") }}?id=' + this.user
                        }).then(response => {
                            this.order_wishlist(response.data);
                        })
                    }
                },

                /* order witshlist for 3 */
                order_wishlist: function (data) {
                    //return false;
                    var order = [];
                    for (var i = 0; i < data.length; i++) {
                        var box = [];
                        var count = 1;
                        while (count <= 3) {
                            if (data[i]) {
                                box.push(data[i]);
                                i++;
                            }
                            count++;
                        }
                        order.push(box);
                        i -= 1;
                    }
                    this.products_wishlist = order;
                },

                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                        if (!this.check_wisht_list(item.id)) {
                            var data = {
                                user_id: this.user,
                                product_id: item.id
                            };

                            axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function (response) {
                                vue_index_commerce.get_wishlist();
                                vue_index_commerce.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
                            })
                        } else
                            this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist') }}", "warning");
                    }
                    else
                        this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
                },

                /* product delete wishlist */
                deleteWishList: function (item) {
                    if (this.user) {
                        var data = {
                            user_id: this.user,
                            product_id: item.id
                        };
                        axios.post('{{ route("icommerce.api.wishlist.delete") }}', data).then(response => {
                            this.get_wishlist();
                            this.alerta("{{trans('icommerce::wishlists.alerts.delete')}}", "success");
                        })

                    }
                    else
                        this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function (id) {
                    var list = this.products_wishlist;
                    var response = false;

                    $.each(list, function (index, box) {
                        $.each(box, function (i, item) {
                            id === item.id ? response = true : false;
                        });
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
                },
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.get_products(this.path);

                    this.get_wishlist();
                    this.preloaded = false;
                    setTimeout(function () {
                        $('#content_preloader').fadeOut(1000, function () {
                            $('#content_index_commerce').animate({'opacity': 1}, 500);
                        });
                    }, 1800);
                })
            }
        });
    </script>
@stop
