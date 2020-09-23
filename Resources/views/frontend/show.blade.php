@extends('layouts.master')

@section('meta')
  <meta name="title" content="{{$product->meta_title??$product->name}}">
  <meta name="keywords" content="{{$product->meta_keyword ?? ''}}">
  <meta name="description" content="{{$product->meta_description??$product->summary}}">
  <meta name="robots"
        content="{{$product->options->meta_robots??'INDEX,FOLLOW'}}">
  <!-- Schema.org para Google+ -->
  <meta itemprop="name"
        content="{{$product->meta_title??$product->name}}">
  <meta itemprop="description"
        content="{{$product->meta_description??$product->summary}}">
  <meta itemprop="image"
        content=" {{url($product->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">
  <!-- Open Graph para Facebook-->

  <meta property="og:title"
        content="{{$product->meta_title??$product->name}}"/>
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="{{$product->url}}"/>
  <meta property="og:image"
        content="{{url($product->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}"/>
  <meta property="og:description"
        content="{{$product->meta_description??$product->summary}}"/>
  <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
  <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
  <meta name="twitter:title"
        content="{{$product->meta_title??$product->name}}">
  <meta name="twitter:description"
        content="{{$product->meta_description??$product->summary}}">
  <meta name="twitter:creator" content="">
  <meta name="twitter:image:src"
        content="{{url($product->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">

@stop

@section('title')
  {{ $product->name }} | @parent
@stop

@section('content')

  <div class="page">
    <div id="content_preloader">
      <div id="preloader"></div>
    </div>

    <div id="content_show_commerce">
      <!-- MIGA DE PAN  -->

      @component('partials.widgets.breadcrumb')
        <li class="breadcrumb-item" v-for="category in categories">
          <a :href="url+'/'+category.slug">@{{category.title}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">@{{product.name}}</li>
      @endcomponent

      <div id="content" class="product">
        <div class="container ">

          <div class="row">
            <div class="col-lg-6 mb-5">

              @includeFirst(['icommerce.widgets.gallery','icommerce::frontend.widgets.gallery'])

            </div>

            <div class="col-lg-6 mb-5">
              @includeFirst(['icommerce.widgets.information','icommerce::frontend.widgets.information'])
              <div class="row">
                <div class="col-12">
                  <h5 class="pay mb-3">MEDIOS DE PAGO</h5>
                </div>
                <div class="bg-img1 col-auto text-center">
                  <img src="/assets/media/iconos/ic-tarjetas.png" alt="Tarjeta de Débito y Crédito">
                  Tarjeta de Crédito <br> y Débito
                </div>
                <div class="bg-img1 col-auto text-center">
                  <img src="/assets/media/iconos/ic-consignacion.png" alt="Consignación">
                  Consignación
                </div>
                <div class="bg-img1 col-auto text-center">
                  <img src="/assets/media/iconos/ic-transferencias.png" alt="Transferecia">
                  Transferecia
                </div>
                <div class="bg-img1 col-auto text-center">
                  <img src="/assets/media/iconos/ic-pagotienda.png" alt="Pago en tienda">
                  Pago en tienda
                </div>
                <div class="col-12 py-3">
                  <div class="row">
                    <div class="bg-img2 col-auto text-center">
                      <img src="/assets/media/paginas/prosperando-gris-claro-metodo-de-pago.jpg" alt="Prosperando">
                    </div>
                    <div class="bg-img2 col-auto text-center">
                      <img src="/assets/media/paginas/efecty.png" alt="Efecty">
                    </div>
                  </div>
                </div>
              </div>
              <hr class="mt-0">
              <div class="row">
                <div class="bg-img3 col-auto">
                  <img src="/assets/media/iconos/ic-compra-segura.png" alt="Compra Segura">
                  <a href="{{url('compra-segura')}}" style="color: #666666;">Compra Segura</a>
                </div>
                <div class="bg-img3 col-auto">
                  <img src="/assets/media/iconos/ic-politica-envios.png" alt="Política de Envío">
                  <a href="{{url('politica-de-entrega-garantia-y-envio')}}" style="color: #666666;">Política de Envío</a>
                </div>
                <div class="bg-img3 col-auto">
                  <img src="/assets/media/iconos/ic-politica-devolucion.png" alt="Política de Devolución">
                  <a href="{{url('politica-de-devolucion')}}" style="color: #666666;">Política de Devolución</a>
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-5">
              <div class="row">
                <div class="col-12 ">
                  <ul class="nav nav-tabs border-left border-right border-top" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#descripcion"
                         role="tab">Detalles del Productos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#comentarios"
                         role="tab">Comentarios </a>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Tab panes -->
              <div class="row">
                <div class="col-12">
                  <div class="tab-content border">
                    <div class="tab-pane active " id="descripcion" role="tabpanel">
                      <div class="p-3 p-md-5">
                        @includeFirst(['icommerce.products.tabs','icommerce::frontend.products.tabs'])
                      </div>

                    </div>
                    <div class="tab-pane" id="comentarios" role="tabpanel">
                      <div class="p-3 p-md-5">
                        <div class="fb-comments w-100" v-bind:data-href="product.url" data-numposts="5"
                             data-width="100%"></div>
                        <div id="fb-root"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              @includeFirst(['icommerce.products.related-products','icommerce::frontend.products.related-products'])
            </div>

          </div>
        </div>
      </div>
    </div>

    @include('partials.subcription')

    @include('partials.brands')

  </div>

@stop
@section('scripts')
  @parent
  <script>
    /********* VUE ***********/
    var vue_show_commerce = new Vue({
      el: '#content_show_commerce',
      data: {
        path: '{{ route('api.icommerce.products.show',[$product->id]) }}',
        product: '',
        product_gallery: [],
        products: [],
        products_children: false,
        products_children_cart: [],
        related_products: false,
        relatedProducts: [],
        quantity: 1,
        currency: '',
        url: "{{url('/')}}",
        /*wishlist*/
        wishList: false,
        products_wishlist: [],
        user: {{$currentUser->id??0}},
        product_comments: [],
        count_comments: 0,
        product_parent: false,
        products_brother: false,
        /*breadcrumb*/
        index_product_option_value_selected: "select",
        option_type: null,
        option_value: '',
        breadcrumb: [],
        categories: [], /*SUBCATEGORIAS*/
        sending_data: false,
        currencysymbolleft: icommerce.currencySymbolLeft,
        currencysymbolright: icommerce.currencySymbolRight,
        productOptValueSelected: [],
        /*paginacion*/
        prev: '#',
        next: '#',
        video: '',
        pathOptions: '{{ route('api.icommerce.product-option.index') }}',
        productOptions : [],
        productOptionsSelected : false
      },
      created: function () {
        this.$nextTick(function () {
          this.get_product();
          //this.getProducts();
          setTimeout(function () {
            $('#content_preloader').fadeOut(1000, function () {
              $('#content_show_commerce').animate({'opacity': 1}, 500);
            });
          }, 1800);
        });
      },
      filters: {
        numberFormat: function (value) {
          return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
      },
      methods: {
        loadCategory(indexCategory) {
          window.location = this.url + '/' + indexCategory.slug;
        },
        getProducts() {
          console.warn('Get Products')
          axios({
            method: 'Get',
            responseType: 'json',
            url: "{{ route('api.icommerce.products.index') }}",
            params: {
              include: 'categories,productOptions,optionValues,category,wishlists',
            }
          }).then(response => {
            console.warn(response)
            vue_show_commerce.products = response.data.data;
            vue_show_commerce.products.forEach(function (valor, indice, array) {


              if (vue_show_commerce.product.id == valor.id) {

                if ((indice - 1) > 0) {
                  vue_show_commerce.prev = vue_show_commerce.url + '/' + vue_show_commerce.products[indice - 1].slug;
                }
                if (Array.isArray( vue_show_commerce.products) && (indice + 1) < vue_show_commerce.products.length) {
                  vue_show_commerce.next = vue_show_commerce.url + '/' + vue_show_commerce.products[indice + 1].slug;
                }
              }
            });

          }).catch(e => console.warn('>>>>>>',e));


        },
        /* actualizar precio de producto */
        update_product: function (indexOption, indexValue) {
          // console.log(indexOption, indexValue);
          vue_show_commerce.option_type = vue_show_commerce.product.productOptions[indexOption].type;
          if (vue_show_commerce.index_product_option_value_selected != "select") {
            vue_show_commerce.option_value = vue_show_commerce.product.productOptions[indexOption].optionValue;
            option = vue_show_commerce.product.optionValues[indexValue];
            // console.log(option);
            if (parseFloat(option.price) != 0.00) {
              if (option.pointsPrefix == "+") {
                vue_show_commerce.product.price = parseFloat(vue_show_commerce.product.price) + parseFloat(option.price);
                // console.log(vue_show_commerce.product.price);
                this.productOptValueSelected = [option];
              }
            }
          } else {

          }

          console.warn(this.productOptValueSelected)
        },
        /* obtiene los productos */
        get_product: function () {
          axios({
            method: 'Get',
            responseType: 'json',
            url: this.path,
            params: {
              include: 'categories,productOptions,optionValues,category,wishlists,relatedProducts',
            }
          }).then(function (response) {

            vue_show_commerce.product = response.data.data;
            vue_show_commerce.categories = response.data.data.categories.reverse();
            vue_show_commerce.video = response.data.data.options.video;
            vue_show_commerce.product_gallery = response.data.data.gallery;
            vue_show_commerce.currency = "$";
            vue_show_commerce.relatedProducts = response.data.data.relatedProducts;
            vue_show_commerce.get_product_options();
          });

        },
        get_product_options: function () {
          axios({
            method: 'Get',
            responseType: 'json',
            url: this.pathOptions,
            params: {
              filter: {productId: this.product.id},
              include: 'productOptionValues'
            }
          }).then(function (response) {
            vue_show_commerce.productOptions = vue_show_commerce.builTree(response.data.data)
          });
        },

        builTree(elements, parentId = 0) {
          var branch = [];
          elements.forEach(element => {
            element.parentId ? false : element.parentId = 0
            if (element.parentId == parentId) {
              var children = vue_show_commerce.builTree(elements, element.id);
              let record = element
              if (children.length)
                record['children'] = children
              branch.push(record);
            }
          })

          return branch;
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

          if (Array.isArray(products.length) && products.length >= 1) ;
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
          //Validate if options required is selected
          if(this.productOptionsSelected.required)
            return toastr.error("Faltan opciones requeridas por seleccionar");

          vue_show_commerce.sending_data = true;
          vue_carting.addItemCart(
            data.id,
            data.name,
            (data.price + this.productOptionsSelected.total),
            this.quantity,
            this.productOptionsSelected.options
          );
          vue_show_commerce.quantity = 1;
          vue_show_commerce.sending_data = false;

        },

        /* products wishlist */
        get_wishlist: function () {
          if (this.user) {
            axios({
              method: 'get',
              responseType: 'json',
              url: Laravel.routes.wishlist.get + '?filter={' + this.user + '}'
            }).then(response => {
              this.products_wishlist = response.data.data;
              $.each(this.products_wishlist, function (index, item) {
                if (vue_show_commerce.product.id == item.product_id) {
                  button = $('.btn-wishlist').prop("disabled", false);
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
              axios.post("{{url('/')}}" + "/api/icommerce/v3/wishlists", {
                attributes: {
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
          } else {
            this.alerta("Por Favor, Inicie Sesion", "warning");
          }
        },

        /*check if exist product in wisthlist*/
        check_wisht_list: function (id) {
          var response = false;
          $.each(this.products_wishlist, function (index, item) {
            if (id == item.product_id) {
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
