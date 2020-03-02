
@extends('layouts.master')

@section('meta')
    <meta name="title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="keywords" content="{!!isset($product->options->meta_keyword) ? $product->options->meta_keyword : ''!!}">
    <meta name="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary!!}">
    <meta name="robots"
          content="{{isset($product->options->meta_robots)?$product->options->meta_robots : 'INDEX,FOLLOW'}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta itemprop="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta itemprop="image"
          content=" {{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg') }}">
    <!-- Open Graph para Facebook-->

    <meta property="og:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{url($product->slug)}}"/>
    <meta property="og:image"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}"/>
    <meta property="og:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="twitter:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image:src"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}">

@stop

@section('title')
    {{ $product->title }} | @parent
@stop

@section('content')
@include('partials.header')

    <div id="content_preloader" class="mt-4">
        <div id="preloader"></div>
    </div>

    <div class="container-fluid    bg-top"></div>
    <div id="content_show_commerce" class="page">
        <!-- MIGA DE PAN  -->
        <div class="container">
            <div class="row">
              <div class="col-12 col-md-6 d-flex align-items-center">
               @component('partials.widgets.breadcrumb')
                <li class="breadcrumb-item" v-for="category in breadcrumb"><a v-bind:href="category.url">@{{category.title }}</a> </li>
                <li class="breadcrumb-item active" aria-current="page">@{{product.name}}</li>
                @endcomponent

              </div>
            </div>
        </div>

        <div class="filters">
          <div class="content container">

              <div class="row">
                <!-- Search -->
                <div class="col-12 col-md-6">
                        @include('icommerce.widgets.searcher')
                </div>

                <!-- #content-page -->
                <div class="col-12 col-md-6 ">
                  <ul class="nav nav-tabs d-flex justify-content-md-end justify-content-center align-items-center" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link"  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Categoría </a>
                    </li>
                     <li class="nav-item">
                      <div >
                        <a class="nav-link2"  v-bind:href="prev"  aria-label="Previous">
                            <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                        </a>

                      </div>

                    </li>

                    <li class="nav-item">
                        <div>
                          <a class="nav-link2" v-bind:href="next"  aria-label="Next"  >
                            <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                        </a>

                        </div>

                    </li>

                  </ul>
                </div>
              </div>

                 <div class="collapse" id="collapseExample">
                        <div class="row filter">
                            <div class="tab-content col-12">
                                <div class="tab-pane active" >
                                     @include('icommerce.widgets.categories')
                                </div>
                            </div>
                        </div>

                </div>

            </div>
        </div>
        <!-- CONTENT -->
        <div id="content" class="section-product">
            <div class="container">
                <div class="row">
                    <!-- ===== CONTENT ===== -->
                    <div id="content">
                        <div class="row justify-content-between">


                          <div class="col-md-12 col-lg-6 img-product">


                                    @include('icommerce.widgets.gallery')

                            </div>
                            <div class="col-md-12 col-lg-6 description-product">
                                 @include('icommerce.widgets.information')
                                 @include('icommerce.products.share')
                            </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="bg-gris content-descrip">
                <div class="container">

                    <div class="row">
                        <div class="col-12 col-md-6 ">
                          <ul class="nav nav-tabs d-flex justify-content-between" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active text-uppercase" data-toggle="tab" href="#descripcion" role="tab">{{trans('icommerce::products.table.description')}} </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#comentarios" role="tab">COMENTARIOS </a>
                            </li>
                          </ul>
                        </div>
                    </div>

                      <!-- Tab panes -->
                      <div class="row">

                          <div class="tab-content col-12">
                            <div class="tab-pane active " id="descripcion" role="tabpanel">
                                @include('icommerce.products.tabs')
                            </div>
                            <div class="tab-pane" id="comentarios" role="tabpanel" >
                                <div class="fb-comments w-100" v-bind:data-href="product.url" data-numposts="5" data-width="100%"> </div>
                                <div id="fb-root"></div>
                            </div>
                          </div>
                      </div>
                </div>
            </div>
    </div>


<div id="best">

<div class="container">
      <div class="row contenedor-titulo margin-titulo">
      <div class="icontenteditable col-12 col-md-5  titulo2">
              Productos Destacados
          </div>
          <div class="titulo-separador col-12 col-md-7  "></div>
      </div>
    </div>


    <div class="content products-index container  container-products-carousel" id="container-productos-carousel">
        <carousel-products class="row" col="col-12" name="solicitados" route='{{url("/")}}/api/icommerce/v3/products?filter={"bestsellers":1}' >
        </carousel-products>
      </div>
</div>

@stop


@section('scripts')
    @parent

<script>
 new Vue({
  el: '#best',

})
</script>
    <script>
        /********* VUE ***********/
        var vue_show_commerce = new Vue({
            el: '#content_show_commerce',
            created: function () {
                this.$nextTick(function () {
                    this.get_product();
                    this.getProducts();
                    this.get_wishlist();
                    setTimeout(function () {
                        $('#content_preloader').fadeOut(1000, function () {
                            $('#content_show_commerce').animate({'opacity': 1}, 500);
                        });
                    }, 1800);
                });
            },
            mounted: function () {

            },

            data: {
                path: '{{ route('api.icommerce.products.show',[$product->id]) }}',
                product: '',
                product_gallery: [],
                products: [],
                products_children: false,
                products_children_cart: [],
                related_products: false,
                quantity: 1,
                currency: '',
                url:"{{url('/')}}",
                /*wishlist*/
                wishList:false,
                products_wishlist: [],
                user: {!! $currentUser??null !!},
                product_comments: [],
                count_comments: 0,
                product_parent: false,
                products_brother: false,
                /*breadcrumb*/
                index_product_option_value_selected:"select",
                option_type:null,
                option_value:'',
                breadcrumb: [],
                categories: [], /*SUBCATEGORIAS*/
                sending_data: false,
                currencysymbolleft: icommerce.currencySymbolLeft,
                currencysymbolright: icommerce.currencySymbolRight,
                productOptValueSelected:[],
                /*paginacion*/
                prev:'#',
                next:'#',

            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
              loadCategory(indexCategory){
                window.location=this.url+'/'+indexCategory.slug;
              },

                getProducts() {
                axios({
                      method: 'Get',
                      responseType: 'json',
                      url: "{{ route('api.icommerce.products.index') }}",
                      params: {
                        include: 'categories,productOptions,optionValues,category,wishlists',
                      }
                    }).then(response=> {
                      vue_show_commerce.products = response.data.data;
                      vue_show_commerce.products.forEach( function(valor, indice, array) {


                        if(vue_show_commerce.product.id==valor.id){

                            if ((indice-1)>0) {
                              vue_show_commerce.prev=vue_show_commerce.url+'/'+vue_show_commerce.products[indice-1].slug;
                            }
                            if ((indice+1)<vue_show_commerce.products.length) {
                              vue_show_commerce.next=vue_show_commerce.url+'/'+vue_show_commerce.products[indice+1].slug;
                            }
                        }
                        });

                });



              },

              /* actualizar precio de producto */
                update_product: function (indexOption, indexValue){
                    // console.log(indexOption, indexValue);
                    vue_show_commerce.option_type=vue_show_commerce.product.productOptions[indexOption].type;
                    if(vue_show_commerce.index_product_option_value_selected!="select"){
                        vue_show_commerce.option_value=vue_show_commerce.product.productOptions[indexOption].optionValue;
                        option=vue_show_commerce.product.optionValues[indexValue];
                        // console.log(option);
                        if(parseFloat(option.price)!=0.00){
                            if(option.pointsPrefix=="+"){
                              vue_show_commerce.product.price=parseFloat(vue_show_commerce.product.price)+parseFloat(option.price);
                              // console.log(vue_show_commerce.product.price);
                              this.productOptValueSelected=[option];
                            }
                        }
                    }else{

                    }
                },
                /* obtiene los productos */
                get_product: function () {
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: this.path,
                        params: {
                            include: 'categories,productOptions,optionValues,category,wishlists',
                        }
                    }).then(function (response) {

                        vue_show_commerce.product = response.data.data;
                        vue_show_commerce.categories = response.data.data.categories;
                        vue_show_commerce.product_gallery = response.data.data.gallery;
                        vue_show_commerce.currency = "$";
                    });

                },

                /*change quantity, product children*/
                check_children: function (tr, operation, product) {
                    (operation === '+') ?
                        product.quantity_cart < parseInt(product.quantity) ?
                            product.quantity_cart++ :
                            this.alerta("{{trans('icommerce::products.alerts.no_more')}}", "warning")
                        :
                        false;
                    (operation === '-') ?
                        (product.quantity_cart >= 1) ?
                            product.quantity_cart-- :
                            this.alerta("{{trans('icommerce::products.alerts.no_zero')}}", "warning")
                        :
                        false;

                    this.save_product_children(product.quantity_cart, product);
                },

                /*save/update/delete product for add to cart*/
                save_product_children: function (quantity, product) {
                    var products = this.products_children_cart;
                    var pos = -1;

                    if (products.length >= 1) ;
                    {
                        $.each(products, function (index, item) {
                            item.id === product.id ? pos = index : false;
                        });
                    }

                    if (parseInt(quantity)) { /*add/update item*/


                        pos >= 0 ?
                            this.products_children_cart[pos] = product :
                            this.products_children_cart.push(product);

                    } else if (!parseInt(quantity) && pos !== -1) {/*delete item*/
                        this.products_children_cart.splice(pos, 1);
                    }
                },

                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                  vue_show_commerce.sending_data = true;
                  vue_carting.addItemCart(data.id,data.name,data.price,this.quantity,this.productOptValueSelected);
                  vue_show_commerce.quantity = 1;
                  vue_show_commerce.sending_data = false;

                },

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
                /*get comments of product*/
                get_comments: function () {
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: this.path
                    }).then(function (response) {
                        vue_show_commerce.product_comments = response.data.product_comments;
                        vue_show_commerce.count_comments = response.data.count_comments;
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
                }
            }
        });


        $(document).ready(function () {

            $('#owl-image-mini').owlCarousel({
                loop: true,
                margin: 2,
                responsiveClass: true,
                dots: false,
                nav: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 3
                    }
                }
            })

        });

    </script>



    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

@stop
