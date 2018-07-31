@extends('layouts.master')

@section('meta')
  <meta name="title" content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
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
  <meta itemprop="image" content=" {{url($product->options->mainimage) }}">
  <!-- Open Graph para Facebook-->
  <meta property="og:title"
        content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}"/>
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{url($product->slug)}}"/>
  <meta property="og:image" content="{{url($product->options->mainimage)}}"/>
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
  <meta name="twitter:image:src" content="{{url($product->options->mainimage)}}">

@stop

@section('title')
  {{ $product->title }} | @parent
@stop

@section('content')
  
  <!-- preloader -->
  <div id="content_preloader">
    <div id="preloader"></div>
  </div>
  
  <div id="content_show_commerce"
       class="page"
       data-icontenttype="page"
       style="opacity: 0"
       data-icontentid="3">
    
    <!-- ===== PAGINATE ====== -->
    <div class="iblock general-block31 no-print" data-blocksrc="general.block31">
      <div class="container">
        <div class="row">
          <div class="col">
            
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mt-4 text-uppercase">
                <li class="breadcrumb-item">
                  <a href="{{ url('/') }}">{{trans('icommerce::common.home.title')}}</a>
                </li>
                <li class="breadcrumb-item" v-for="category in breadcrumb">
                  <a v-bind:href="category.url">
                    @{{ category.title }}
                  </a>
                </li>
                <li class="breadcrumb-item active"
                    aria-current="page">
                  @{{ product.title }}
                </li>
              </ol>
            </nav>
          
          </div>
        </div>
      </div>
    </div>
    
    <!-- ==== CONTENT ==== -->
    <div class="iblock general-block32" data-blocksrc="general.block32">
      
      <div class="container">
        <div class="row">
          
          <!-- photo and gallery -->
          <div class="col-sm-12 col-md-5 pb-4 print-40">
            <div class="pb-5">
              <div class="carousel-product">
                <div class="zoom-product">
                  <div class="big-img" style="height: 480px">
                    
                    <div class="background_image no-print"
                         :style="'background-image: url('+product.mainimage+')'">
                    </div>
                    
                    <img class="img-fluid w-100 print-img" v-bind:src="product.mainimage" alt="" style="display: none">
                  </div>
                </div>
                
                <div id="owl-carousel-product" class="owl-carousel">
                  <div class="owl-item">
                    <img v-bind:src="product.mainimage" alt="">
                  </div>
                  <!--
                  <div class="owl-item" v-for="(img,index) in product_gallery">
                      <img v-bind:src="product_gallery[index]" alt="">
                  </div>
                  -->
                </div>
              </div>
            </div>
            
            <div class="pb-5 no-print">

            </div>
          </div>
          
          <!-- dates -->
          <div class="col-sm-12 col-md-7 print-60">
            <!-- title -->
            <h1>
            {{ $product->title }}
            <!-- SKU -->
              <br>
              <small class="text-danger font-weight-bold" style="font-size: 15px">
                {{trans('icommerce::cart.table.sku')}}#: {{ $product->sku }}
              </small>
            </h1>
            
            <!-- word -->
            <h6>
              <small>
                <a
                  href="#tabp3"
                  aria-controls="tabp3"
                  aria-selected="false">
                  {{trans('icommerce::products.messages.be_the_fist_review')}}
                </a>
              </small>
            </h6>
            
            <!-- STARTS -->
            <span style="font-size: 12px">
                            <i class="fa fa-star pr-1"
                               v-bind:class="[product.rating >= star ? 'text-warning' : 'text-muted']"
                               v-for="(star,key) in 5"></i>
                        </span>
            
            <div class="row align-items-center pt-2">
              <!-- price -->
              <div class="col-md-4 price mr-5" v-if="products_children === false">
                <p class="h4 font-weight-bold mb-1">
                  <del class="text-muted pr-2"
                       v-if="product.price_discount"
                       style="font-size: 14px">
                    @{{ currency.symbol_left }} @{{ product.price }} @{{ currency.symbol_right }}
                  </del>
                  <span class="text-danger font-weight-bold"
                        v-if="!product.price_discount">
                                        @{{ currency.symbol_left }} {{ formatMoney($product->price) }} @{{ currency.symbol_right }}
                                    </span>
                  <span class="text-danger font-weight-bold"
                        v-if="product.price_discount">
                                        @{{ currency.symbol_left }} {{  formatMoney($product->price_discount)  }}
                    @{{ currency.symbol_right }}
                                    </span>
                </p>
              </div>
              
              <div v-if="product.pdf" class="col pdf">
                <a v-bind:href="product.pdf"
                   class="btn btn-outline-light text-dark">
                  <img class="img-fluid p-2 pr-3"
                       src="{{ Theme::url('img/pdf.png') }}">
                  {{trans('icommerce::products.messages.product_brochure')}}
                </a>
              </div>
            </div>
            
            <div class="w-100"></div>
            
            <div class="py-3 no-print" v-if="!products_children">
              
              <div class="input-group mb-3 w-25 float-left pr-2">
                <div class="input-group-prepend">
                  <button class="btn btn-outline-primary"
                          type="button"
                          field="quantity"
                          v-on:click="quantity >= 2 ? quantity-- : false">
                    -
                  </button>
                </div>
                <input type="text"
                       class="form-control border-primary text-center"
                       name="quantity"
                       v-model="quantity"
                       aria-label=""
                       aria-describedby="basic-addon1">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary"
                          type="button"
                          field="quantity"
                          v-on:click="quantity < product.quantity ? quantity++ : false">
                    +
                  </button>
                </div>
              </div>
              
              <a class="btn btn-outline-primary text-primary"
                 v-on:click="addWishList(product)">
                <i class="fa fa-heart">
                </i>
              </a>
            </div>
            
            <div class="py-3 no-print" v-if="!products_children">
              <button class="btn btn-danger text-white addToCar w-30"
                      v-on:click="addCart(product)" v-show="!sending_data">
                <i class="fa fa-shopping-cart pr-3"></i>
                {{trans('icommerce::products.alerts.add')}}
              </button>
              <button class="btn btn-danger text-white w-30" v-show="sending_data">
                <div class="fa-1x"><i
                    class="fa fa-spinner fa-pulse"></i>{{trans('icommerce::products.messages.sending')}}</div>
              </button>
            </div>
            
            <!-- Sub products -->
            <table id="table_children"
                   class="table table-responsive mb-0 cart-table w-100"
                   v-if="products_children != false">
              <thead>
              <tr>
                <th class="text-center w-15"></th>
                <th class="text-center w-35">{{trans('icommerce::products.single')}}</th>
                <th class="text-center w-10">{{trans('icommerce::cart.table.sku')}}</th>
                <th class="text-center w-15">{{trans('icommerce::cart.table.unit_price')}}</th>
                <th class="text-center w-10">{{trans('icommerce::cart.table.quantity')}}</th>
                <th class="w-15 text-md-right">{{trans('icommerce::cart.table.secondary_total')}}</th>
              </tr>
              </thead>
              <tbody>
              <!-- Children Product -->
              <tr v-for="(sub,index) in products_children"
                  v-bind:class="[sub.id == product.id ? 'subproduct-active' : '']">
                <!-- image -->
                <td class="text-center">
                  <a v-bind:href="sub.url">
                    <img class="cart-img img-fluid"
                         v-bind:src="sub.mainimage"
                         style="height: 70px"
                         v-bind:alt="sub.title">
                  </a>
                </td>
                <!-- title -->
                <td style="font-size: 12px">
                                    <span class="font-weight-bold">
                                        <a :class="[sub.id != product.id ? 'text-dark' : '']" v-bind:href="sub.url">
                                            @{{ sub.title }}
                                        </a>
                                    </span>
                </td>
                <!-- sku -->
                <td class="text-center" style="font-size: 12px">
                                    <span class="font-weight-bold">
                                        <a>@{{ sub.sku }}</a>
                                    </span>
                </td>
                <!-- price -->
                <td class="text-center align-middle" style="font-size: 12px">
                  $ @{{ sub.price }}
                </td>
                <!-- quantity -->
                <td style="font-size: 12px">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary"
                              type="button"
                              field="quantity"
                              v-on:click="check_children(index,'-',sub)"
                              style="padding: 4px">
                        -
                      </button>
                    </div>
                    <input type="text"
                           class="form-control border-primary text-center"
                           name="quantity"
                           v-model="sub.quantity_cart"
                           value="0"
                           aria-describedby="basic-addon1"
                           style="font-size: 12px; padding: 6px">
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary"
                              type="button"
                              field="quantity"
                              v-on:click="check_children(index,'+',sub)"
                              style="padding: 4px">
                        +
                      </button>
                    </div>
                  </div>
                </td>
                <td class="text-md-right"
                    style="font-size: 12px">
                                    <span class="font-weight-bold">
                                        @{{ currency.symbol_left }}
                                        <span class="price_children">
                                            @{{ parseFloat(sub.price.replace(',', '')) * sub.quantity_cart | numberFormat }}
                                        </span>
                                        @{{ currency.symbol_right }}
                                    </span>
                </td>
              </tr>
              </tbody>
            </table>
            
            <div class="py-3 mb-3 no-print" v-if="products_children != false">
              <button class="btn btn-danger text-white w-30"
                      v-on:click="addCart()" v-show="!sending_data">
                <i class="fa fa-shopping-cart pr-3"></i>
                {{trans('icommerce::products.alerts.add')}}
              </button>
              
              <button class="btn btn-danger text-white w-30" v-show="sending_data">
                <div class="fa-1x"><i
                    class="fa fa-spinner fa-pulse"></i>{{trans('icommerce::products.messages.sending')}}</div>
              </button>
            </div>
            
            <div class="py-2 mt-3 no-print">
              <a
                href="javascript:window.open('http://www.facebook.com/sharer.php?u=' + vue_show_commerce.product.url,'Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')"
                class="btn btn-outline-dark btn-sm mb-2 buton-social">
                <i class="fa fa-facebook"></i>
                {{trans('icommerce::products.messages.share')}}
              </a>
              <a
                href="javascript:window.open('http://twitter.com/share?url=' + vue_show_commerce.product.url,'Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')"
                class="btn btn-outline-dark btn-sm mb-2 buton-social">
                <i class="fa fa-twitter"></i>
                {{trans('icommerce::products.messages.tweet')}}
              </a>
              <a
                href="javascript:window.open('https://plus.google.com/share?url=' + vue_show_commerce.product.url,'Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+'')"
                class="btn btn-outline-dark btn-sm mb-2 buton-social">
                <i class="fa fa-google-plus"></i>
                {{trans('icommerce::products.messages.share')}}
              </a>
              <a href="javascript:window.print()"
                 class="btn btn-outline-dark btn-sm mb-2 buton-social">
                <i class="fa fa-print"></i>
                {{trans('icommerce::products.messages.print')}}
              </a>
            </div>
            
            <div class="py-3 no-print">
              <img class="img-fluid pr-4 mb-3"
                   src="{{ Theme::url('img/paypal.png') }}">
              <img class="img-fluid mb-3"
                   src="{{ Theme::url('img/paypal-credit.png') }}">
            </div>
            
            <div class="row border border-right-0 border-left-0 my-4 mx-1 no-print">
              <div class="col-auto">
                <div class="media  py-4">
                  <img class="align-self-center mr-3"
                       src="{{ Theme::url('img/car.png') }}">
                  <div class="media-body text-left">
                    <p class="m-0">{{trans('icommerce::products.messages.business_days')}}<br>
                      {{trans('icommerce::products.messages.average_delivery')}}</p>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="media py-4">
                  <img class="align-self-center mr-3"
                       src="{{ Theme::url('img/save.png') }}">
                  <div class="media-body text-left">
                    <p class="m-0">{{trans('icommerce::products.messages.safe_secure')}}<br>
                      {{trans('icommerce::products.messages.shopping')}}</p>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="media py-4">
                  <img class="align-self-center mr-3"
                       src="{{ Theme::url('img/day.png') }}">
                  <div class="media-body text-left">
                    <p class="m-0">{{trans('icommerce::products.messages.safe_secure')}}<br>
                      {{trans('icommerce::products.messages.shopping')}}</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="w-100"></div>
          
          </div>
          
          <div class="w-100"></div>
          
          <div class="pt-5 pb-3 w-100">
            
            <ul class="nav nav-tabs bg-light w-100"
                id="myTab"
                role="tablist">
              <li class="nav-item">
                <a class="nav-link border-0 rounded-0 active buton-social"
                   id="tabp1"
                   data-toggle="tab"
                   href="#details"
                   role="tab"
                   aria-controls="details"
                   aria-selected="true">
                  {{trans('icommerce::products.messages.details')}}
                </a>
              </li>
              {{--<li class="nav-item">
                  <a class="nav-link border-0 rounded-0"
                     id="tabp2"
                     data-toggle="tab"
                     href="#shipping"
                     role="tab"
                     aria-controls="shipping"
                     aria-selected="false">
                      SHIPPING INFO
                  </a>
              </li>--}}
              <li class="nav-item">
                <a class="nav-link border-0 rounded-0 buton-social"
                   id="tabp3"
                   data-toggle="tab"
                   href="#reviews"
                   role="tab"
                   aria-controls="reviews"
                   aria-selected="false">
                  {{trans('icommerce::products.messages.reviews')}} (@{{ count_comments }})
                </a>
              </li>
            </ul>
            <div class="tab-content w-100" id="myTabContent">
              <div class="tab-pane py-4 px-2 fade show active"
                   id="details"
                   role="tabpanel"
                   aria-labelledby="tabp1">
                <div v-html="product.description">
                  {{ $product->description}}
                </div>
              </div>
              {{--<div class="tab-pane py-4 px-2 fade"
                   id="shipping"
                   role="tabpanel"
                   aria-labelledby="tabp2">
                  <p class="text-justify">
                      This strong tether, made from 1-inch tubular web with a built-in
                      bungee, works as a “live bait” water rescue attachment to your PFD.
                      As a connection between a PFD and a line, the tether enhances
                      attachment options in rescue situations. Comes with brite
                      double-locking connector. Rated strength: 11 kN (2,473 lbf)
                  </p>
              </div>--}}
              <div class="tab-pane py-4 px-2 fade"
                   id="reviews"
                   role="tabpanel"
                   aria-labelledby="tabp3">
                
                <div class="fb-comments"
                     v-bind:data-href="product.url"
                     data-numposts="5"
                     data-width="100%">
                
                </div>
                
                <div id="fb-root"></div>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <hr>
    @include('icommerce.widgets.related_products')
  
  </div>
  
  <style>
    .subproduct-active {
      background-color: #0F4A5B;
      color: white;
    }
    
    .subproduct-active td span a {
      color: white;
    }
    
    .subproduct-active td span a:hover {
      color: #25858a;
    }
  </style>
@stop

@section('scripts')
  @parent
  {!!Theme::script('js/app.js?v='.config('app.version'))!!}
  
  <style>
    @media print {
      body * {
        visibility: hidden;
      }
      
      .no-print {
        display: none;
      }
      
      .print-40 {
        margin-top: 60px;
        width: 40%;
      }
      
      .print-60 {
        margin-top: 60px;
        width: 60%;
      }
      
      .print-img {
        display: block;
      }
      
      #content_show_commerce * {
        visibility: visible;
      }
      
      #content_show_commerce {
        position: absolute;
        left: 0;
        top: 0;
      }
    }
    
    buton-social:hover {
      color: #ffffff !important;
    }
    
    nav-item a:hover {
      color: #ffffff !important;
    }
  </style>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>
  
  <script type="text/javascript">
    var vue_show_commerce = new Vue({
      el: '#content_show_commerce',
      created: function () {
        this.$nextTick(function () {
          this.get_product();
          this.get_wishlist();
          
          setTimeout(function () {
            $('#content_preloader').fadeOut(1000, function () {
              $('#content_show_commerce').animate({'opacity': 1}, 500);
            });
          }, 1800);
        });
      },
      data: {
        path: '{{ route('icommerce.api.product',[$product->id]) }}',
        product: '',
        product_gallery: [],
        products_children: false,
        products_children_cart: [],
        related_products: false,
        quantity: 1,
        currency: '',
        /*wishlist*/
        products_wishlist: [],
        user: {!! $user !!},
        product_comments: [],
        count_comments: 0,
        product_parent: false,
        products_brother: false,
        /*breadcrumb*/
        breadcrumb: [],
        sending_data: false
      },
      filters: {
        numberFormat: function (value) {
          return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
      },
      methods: {
        /* obtiene los productos */
        get_product: function () {
          axios({
            method: 'Get',
            responseType: 'json',
            url: this.path
          }).then(function (response) {
            
            vue_show_commerce.product = response.data.product[0];
            vue_show_commerce.product_gallery = response.data.product[0].gallery;
            vue_show_commerce.related_products = response.data.related_products;
            vue_show_commerce.currency = response.data.currency;
            vue_show_commerce.product_comments = response.data.product_comments;
            vue_show_commerce.count_comments = response.data.count_comments;
            vue_show_commerce.products_children = response.data.products_children;
            vue_show_commerce.breadcrumb = response.data.breadcrumb;
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
          
          if (parseInt(quantity)) { //add/update item
            //product['quantity_cart'] = quantity;
            
            pos >= 0 ?
              this.products_children_cart[pos] = product :
              this.products_children_cart.push(product);
            
          } else if (!parseInt(quantity) && pos !== -1) {//delete item
            this.products_children_cart.splice(pos, 1);
          }
        },
        
        /*agrega el producto al carro de compras*/
        addCart: function (data) {
          if (data) {
            data['quantity_cart'] = this.quantity;
            data = [data];
          } else {
            data = this.products_children_cart;
          }
          vue_show_commerce.sending_data = true;
          
          axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function (response) {
            if (response.data.status) {
              vue_show_commerce.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
              vue_show_commerce.quantity = 1;
              vue_carting.get_articles();
            } else {
              vue_show_commerce.alerta(
                "{{trans('icommerce::products.alerts.no_add_cart')}}",
                "error");
            }
            vue_show_commerce.sending_data = false;
          });
        },
        
        /* products wishlist */
        get_wishlist: function () {
          if (this.user) {
            axios({
              method: 'get',
              responseType: 'json',
              url: '{{ route("icommerce.api.wishlist.user") }}?id=' + this.user
            }).then(function (response) {
              vue_show_commerce.products_wishlist = response.data;
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
              
              axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function (response) {
                vue_show_commerce.get_wishlist();
                vue_show_commerce.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
              })
            } else {
              this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist')}}", "warning");
            }
          }
          else {
            this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
          }
        },
        
        /*check if exist product in wisthlist*/
        check_wisht_list: function (id) {
          var list = this.products_wishlist;
          var response = false;
          
          $.each(list, function (index, item) {
            id === item.id ? response = true : false;
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
  </script>
  
  <script type="text/javascript">
    $('.zoom-product').zoom({
      magnify: 1
    });
    
    var owla = $("#owl-carousel-product");
    owla.owlCarousel({
      items: 4,
      slideSpeed: 250,
      rewindSpeed: 350,
      margin: 1,
      responsiveClass: true,
      dots: true,
      nav: false
    });
    
    function main_imgbig() {
      var img = $('#owl-carousel-product .owl-item').find('img');
      var e = img.attr('src');
      var carousel = img.closest(".carousel-product");
      
      carousel.children('.zoom-product').trigger('zoom-product.destroy');
      carousel.children('.zoom-product').zoom({url: e});
      carousel.find(".zoom-product .big-img img").attr("src", e);
    }
    
    main_imgbig();
    
    
    $("#owl-carousel-product .owl-item img").bind("click touchstart", function () {
      var e = $(this).attr("src");
      var carousel = $(this).closest(".carousel-product");
      
      carousel.children('.zoom-product').trigger('zoom-product.destroy');
      carousel.children('.zoom-product').zoom({url: e});
      carousel.find(".zoom-product .big-img img").attr("src", e);
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
  
  @include('icommerce::frontend.partials.schema_product')
@stop

