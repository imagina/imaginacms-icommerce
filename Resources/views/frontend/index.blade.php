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



    <div id="content_index_commerce" class="page">

        @if(isset($category) && !empty($category))

             <div class="banner-general py-5"  v-bind:style="{ backgroundImage: 'url(' + categoryimg + ')' }">
                <div class="container">
                    <div class="row justify-content-center align-items-end">
                        <div class="col-12 text-center text-white">
                            <h1 class="mb-0 font-weight-bold d-inline-block bg-primary px-3 py-2">@{{category.title}}</h1>
                        </div>
                        <div class="col-auto text-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent text-white mb-0">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Inicio</a></li>
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

            @component('partials.widgets.breadcrumb-img',array('url'=>'', 'title'=>'Resultado de la busqueda'))
                <li class="breadcrumb-item active" aria-current="page">
                    {{trans('icommerce::common.search.search_result')}}
                    <span class="font-weight-bold">
                        "{{ isset($criterion) ? $criterion : ''}}"
                    </span>
                </li>
            @endcomponent



        @endif

        <div class="container pt-5">
            <div class="row">

                <div class="col-12 text-right pb-5 d-none d-lg-block" v-if="articles.length >= 1">
                    | <span class="mx-2 total-filter"> @{{ totalArticles }} Articulos</span> | @includeFirst(['icommerce.widgets.order_by','icommerce::frontend.widgets.order_by']) |
                </div>


                <div class="col-lg-3 pb-5">
                    @includeFirst(['icommerce.widgets.categories','icommerce::frontend.widgets.categories'])

                    <hr class="border-primary">

                    <div class="d-none d-lg-block">
                      {{--
                        @includeFirst(['icommerce.widgets.destacados','icommerce::frontend.widgets.destacados'])
                      --}}
                    </div>

                </div>
                <div class="col-lg-9 border-left pb-5">
                    <!-- ===== CONTENT ===== -->

                    <div class="text-right pb-5 d-block d-lg-none" v-if="articles.length >= 1">
                        | <span class="mx-2 total-filter"> @{{ totalArticles }} Articulos</span> | @includeFirst(['icommerce.widgets.order_by','icommerce::frontend.widgets.order_by']) |
                    </div>

                    <div id="content">
                        <!-- PRODUCTS -->
                        <h3 class="d-inline-block bg-secondary text-white px-3 py-2"> @{{categorititle}}</h3>


                        <div id="cont_products" class="mt-4">
                            @includeFirst(['icommerce.widgets.products','icommerce::frontend.widgets.products'])
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
                preloaded: true,
                currencySymbolLeft: icommerce.currencySymbolLeft,
                currencySymbolRight: icommerce.currencySymbolRight,
                v_pages: 1,
                ////Paginación
                p_currence: 1,//Página Actual
                pages: 1,//Cantidad de páginas
                totalArticles:0,//Total de registros
                ////Paginación
                r_pages: {
                    first: 1,
                    latest: 5
                },
                /*dates*/
                articles: [],
                categorititle: ' {{$category->title}} ',
                currency: '$',
                /*order*/
                order: {
                    field: 'created_at',
                    way: 'DESC'
                },
                /*manufacturer*/
                /*rango de precio*/
                range_price: {
                    min_price: null,
                    max_price: null
                },                /*Filters !!!!!!!!!!!!!!!!!! */
                category:{!! $category ? json_encode($category) : "''"  !!},
                category_parent: {{$category->id}}, /*CATEGORIA PADRE*/
                categories: [], /*SUBCATEGORIAS*/
                categoryimg: [],
                queryExternalCategory:false,
                indexCategory:0,
                price: {
                    from: 0,
                    to: 999999
                },
                /*order*/
                order_check: 'Organizar Por',
                /*rango de precio*/
                min_price: 0,
                max_price: 999999,
                v_max: false,
                v_min: false,
                /*wishlist*/
                user: {!! $currentUser->id?? "''" !!},
                /*currency*/
                currency: '$',
                preloader: true,
                loadProduct: false,
            },
            mounted: function () {
                this.preloaded = false;
                this.getProducts();
                this.getCategoryChildrens();
                this.getCategory();
                $('#content_preloader').fadeOut(1000, function () {
                    $('#content_index_commerce').animate({'opacity': 1}, 500);
                });
            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            computed:{
              configPagination(){
                let lastPage = this.r_pages.latest
                let currentPage = this.p_current
                console.warn('>>>>>>>>>>>>Pagination',currentPage, lastPage)
                return 'Testtttt Computed'
              }
            },
            methods: {
              /* products wishlist */
                 get_wishlist: function () {
                    if (this.user) {
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: Laravel.routes.wishlist.get+'?filter={' + this.user+'}'
                        }).then(response => {
                            this.products_wishlist = response.data.data;
                            $.each(this.products_wishlist, function (index, item) {
                                if ( vue_show_commerce.product.id==item.product_id) {
                                    button = $('.btn-wishlist').prop( "disabled", false );
                                      button.find("i").addClass('fa-heart').removeClass('fa-heart-o');
                                }
                    });
                        })
                    }
                },

                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                         button = $('.btn-wishlist');
                        button.find("i").addClass('fa-spinner fa-spin').removeClass('fa-heart');
                        if (!this.check_wisht_list(item.id)) {
                            axios.post("{{url('/')}}"+"/api/icommerce/v3/wishlists", {
                                attributes:{
                                    user_id: this.user,
                                    product_id: item.id
                                }
                            }).then(response => {
                                this.get_wishlist();
                                 this.alerta("producto agregado a la lista", "success");
                                 button.find("i").addClass('fa-heart').removeClass('fa-spinner fa-spin');
                            })
                        } else {
                            button.find("i").addClass('fa-heart-o').removeClass('fa-spinner fa-spin');
                            this.alerta("Producto en la lista", "warning");
                        }
                    }
                    else {
                        this.alerta("Por Favor, Inicie Sesion", "warning");
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
                },
              loadCategory(indexCategory){

                this.indexCategory=indexCategory;
                this.queryExternalCategory=true;
                vue_index_commerce.loadProduct = true;
                /*Load Products */
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.products.index') }}",
                  params: {
                    filter:{
                      order: this.order,
                      categories:indexCategory.id
                    },

                    page:1,
                    take:9,
                     include: 'categories,productOptions,optionValues,category,wishlists',
                  }
                }).then(response=> {
                  vue_index_commerce.order_response(response);
                  vue_index_commerce.categorititle=indexCategory.title;
                  vue_index_commerce.loadProduct = false;
                });
              },
              getProducts() {
                var filter={
                  order: this.order,
                  categoryId:this.category.id,
                  priceRange: this.price,
                  status:1,
                  stockStatus:1,
                };
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.products.index') }}",
                  params: {
                    filter:filter,
                    take:9,
                    include: 'categories,productOptions,optionValues,category,wishlists',
                    page:this.p_currence
                  }
                }).then(response=> {
                  vue_index_commerce.order_response(response);
                });
              },
              getCategory() {
                axios({
                    method: 'Get',
                    responseType: 'json',
                    url: icommerce.url+'/api/icommerce/v3/categories/{{$category->id??''}}'
                }).then(response=> {
                    this.categoryimg=response.data.data.mainImage.path;
                    console.log('asd');
                });
              },
              getCategoryChildrens() {
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.categories.index') }}",
                  params: {
                    filter:{
                      parentId:0
                    },
                    include: 'children',
                  }
                }).then(response=> {
                  this.categories=response.data.data;
                });
              },
              /*Order response v2*/
              order_response: function(response){

                /*productos*/
                this.articles=response.data.data;
                /*paginador*/
                this.p_currence = response.data.meta.page.currentPage;
                this.pages = response.data.meta.page.lastPage;
                this.r_pages.latest = response.data.meta.page.lastPage;
                this.totalArticles = response.data.meta.page.total;

              },
              /*Order response v2*/
              /*Limpiar los filtros y traer todos los productos de la categoria*/
              clearAll: function(){
                this.order= {
                  by: 'created_at',
                  type: 'DESC'
                };
                this.indexCategory=0;
                this.queryExternalCategory=false;
                this.getProducts();
              },

              /*change paginate to limit*/
              change_page_limit: function (page, btn) {
                if (btn === 'first') {
                  this.r_pages.first = 1;
                  this.r_pages.latest = this.v_pages;
                }
                if (btn === 'last') {
                  this.r_pages.first = (this.pages - this.v_pages);
                  this.r_pages.latest = this.pages;
                }

                this.getProducts();
              },

              changePage(type,numberPage=0){
                if(type=="first"){
                  this.p_currence=1;
                }else if(type=="last"){
                  this.p_currence=this.r_pages.latest;
                }else if(type=="next"){
                  this.p_currence=this.p_currence+1;
                }else if(type=="back"){
                  if(this.p_currence>1)
                  this.p_currence=this.p_currence-1;
                  else
                  return false;
                }else if(type=="page"){
                  this.p_currence=numberPage;
                }
                this.getProducts();
              },

              /* configura la consulta por order by */
              order_by: function  () {
                switch (this.order_check) {
                  case 'all' :
                  this.order.field = 'created_at';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'rating' :
                  this.order.field = 'rating';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'nameaz' :
                  this.order.field = 'slug';
                  this.order.way = 'asc';
                  this.order = this.order;
                  break;
                  case 'nameza' :
                  this.order.field = 'slug';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'lowerprice' :
                  this.order.field = 'price';
                  this.order.way = 'asc';
                  this.order = this.order;
                  break;
                  case 'higherprice' :
                  this.order.field = 'price';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                }
                this.getProducts();
              },

              /* configuar la consulta por rango de precio */
              filter_price: function (values) {

                this.price = {
                  from: values[0],
                  to: values[1]
                };
                this.getProducts();
              },

              /*agrega el producto al carro de compras*/
              addCart: function (item) {
                vue_carting.addItemCart(item.id,item.name,item.price);
              },

            }
        });
    </script>
@stop
