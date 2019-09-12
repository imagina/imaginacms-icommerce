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
    
 @include('partials.header')
    <!-- preloader -->
    <div id="content_preloader">
        <div id="preloader"></div>
    </div>

    <div class="container-fluid    bg-top"></div>

    <div id="content_index_commerce" class="page">
    <!-- ======== Breadcrumb and title ======== -->      
      @if(isset($category) && !empty($category))      
        <div class="container">
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center">
               @component('partials.widgets.breadcrumb')
                  @if(isset($category->parent) && !empty($category->parent))
                    <li class="breadcrumb-item">
                          <a href="{{ $category->parent->url }}">
                              {{ $category->parent->title }}
                          </a>
                      </li>
                  @endif
                    <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
                  @endcomponent
              </div>
              <div class="col-12 col-md-6">
                <div class="row d-flex justify-content-end">
                  <div class="titulo-separador col-12 col-md-6 "></div>
                  <div class=" col-12 col-md-6 col-lg-auto titulo3 font-weight-bold">
                          {{$category->title}}
                  </div>

                </div>
              </div>
            </div>
          </div>

          @else

          <div class="container">
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center">
               @component('partials.widgets.breadcrumb')
                    <li class="breadcrumb-item active" aria-current="page">
                     {{trans('icommerce::common.search.search_result')}} "{{ isset($criterion) ? $criterion : ''}}"
                    </li>
                  @endcomponent
              </div>
              <div class="col-12 col-md-6">
                <div class="row d-flex justify-content-end">
                  <div class="titulo-separador col-12 col-md-6 "></div>
                  <div class=" col-12 col-md-6 col-lg-auto titulo3 font-weight-bold">
                    {{trans('icommerce::common.search.search_result')}}    "{{ isset($criterion) ? $criterion : ''}}"
                    
                  </div>

                </div>
              </div>
            </div>
          </div>        

      @endif
    <!-- ======== End Breadcrumb and title ======== -->
<!-- ======== #content ======== -->
        <div class="filters">
          <div class="content container"> 
            <div class="row">
              <!-- Search -->

              <div class="col-12 col-md-6">
                                  @include('icommerce.widgets.searcher')

              </div>
               
              <!-- #content-page -->
              
       
              <div class="col-12 col-md-6 ">
                <ul class="nav nav-tabs d-flex justify-content-md-end justify-content-center" role="tablist">
                  <li class="nav-item"  v-if="queryExternalCategory">
                    <a class="nav-link" @click="clearAll()">Volver a la Categorìa principal </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#categorias" role="tab">Categoría </a>
                  </li>
       
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#filtros" role="tab">Filtros </a>
                  </li>           
                </ul>         
              </div>
            </div>
            <!-- Tab panes -->
            <div class="row filter">
               
                <div class="tab-content col-12">
                  <div class="tab-pane" id="categorias" role="tabpanel">
                    @include('icommerce.widgets.categories')
                  </div>
                  <div class="tab-pane row" id="filtros" role="tabpanel">
                   <div class="container">
                     <div class="row">
                      
                              @include('icommerce.widgets.range_price')
                              @include('icommerce.widgets.order_by')
                   
                     </div>
                   </div>
                  </div>
                </div>
            </div>
           
           <!-- Total Results -->
            <div class="row total-results">
                 
       
                <div class="col-12 title">
                  <div class="row contenedor-titulo d-flex justify-content-between">
                        <div class="col-12 col-md-auto titulo4 " v-if="queryExternalCategory">
                           @{{categorititle}}
                        </div>
                        <div class="col-12 col-md-auto titulo4 " v-else>
                               @{{category.title}}
                        </div>
                          <div class="titulo-separador col-12 col-md-9  d-flex justify-content-md-end"></div>
                      </div>
                </div>
       
                <div class="col-12 d-flex justify-content-md-end ">
                  <span>Mostrando los @{{totalArticles}} Resultados</span>
                </div> 
            </div>
            
          </div>
        </div>
      <!-- End Filters -->
          
            <div class="container">
                
                    <!-- ===== CONTENT ===== -->
                    <div id="content">
                      <!-- PRODUCTS -->
                        <div id="cont_products" class="mt-4">
                            @include('icommerce.widgets.products')
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
                categorititle:'',
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
                queryExternalCategory:false,
                indexCategory:0,
                price: {
                    from: 0,
                    to: 999999
                },
                /*order*/
                order_check: 'all',
                /*rango de precio*/
                min_price: 0,
                max_price: 999999,
                v_max: false,
                v_min: false,
                /*wishlist*/
                user: {!! !empty($user)? $user :0 !!},
                /*currency*/
                currency: '$',
                preloader: true,
            },
            mounted: function () {
                this.preloaded = false;
                this.getProducts();
                this.getCategoryChildrens();
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
                /*Load Categories children*/
                // axios({
                //   method: 'Get',
                //   responseType: 'json',
                //   url: "{{ route('api.icommerce.categories.index') }}",
                //   params: {
                //     filter:{
                //       parentId:this.categories[indexCategory].id
                //     }
                //   }
                // }).then(response=> {
                //   this.categories=response.data.data;
                // });
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
                });
              },
              
              getProducts() {
                var filter={
                  order: this.order,
                  categoryId:this.category.id,
                 priceRange: this.price,
                  }

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
              getCategoryChildrens() {
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.categories.index') }}",
                  params: {
                    filter:{
                      parentId:this.category.id
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
              order_by: function (order) {
                this.order_check=order;
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
