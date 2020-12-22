@extends('layouts.master')

@section('meta')
  @if(isset($category) && !empty($category))
      <meta name="description" content="{{$category->meta_description ?? $category->description ?? ''}}">
      <!-- Schema.org para Google+ -->
      <meta itemprop="name" content="{{$category->meta_title ?? $category->title ?? ''}}">
      <meta itemprop="description" content="{{$category->meta_description ?? $category->description ?? ''}}">
      <meta itemprop="image"
            content=" {{url($category->mainimage->path??'modules/icommerce/img/category/default.jpg')}}">
  @endif
@stop
@section('title')
  {{isset($category->title)? $category->title: 'search'}}  | @parent
@stop


@section('content')


    <!-- preloader -->
    <div id="content_preloader" v-if="preloader">
        <div id="preloader"></div>
    </div>

    <div id="content_index_commerce" class="page mt-3">

        <div class="top-page border-top border-bottom">
          <div class="container">
            <div class="row ">
              <div class="col-lg-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb bg-transparent text-white mb-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Lista de deseos
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <div class="container pt-5">
            <div class="row">

                <div class="col-lg-12  pb-5">
                    <div id="cont_products" class="mt-4">

                      <div class="table-responsive">
                        <table class="table table-bordered table-shape">
                          <thead>
                            <tr>
                              <th>Imagen</th>
                              <th>Producto</th>
                              <th>Precio</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="wishlist in wishlists" v-if="wishlist.product">
                              <td>
                                <img :src="wishlist.product.mainImage.path" :alt="wishlist.product.name" class="img-responsive img-fluid" style="width:200px;height:200px;">
                              </td>
                              <td>@{{wishlist.product.name}}</td>
                              <td>@{{wishlist.product.price | numberFormat}}</td>
                              <td>
                                <a title="Agregar al carro de compras" @click="addCart(wishlist.product);deleteWishlist(wishlist.id)" v-show="wishlist.product.price > 0" class="cart text-primary cursor-pointer">
                                    <i class="fa fa-shopping-basket" style="margin: 0 5px;"></i>
                                </a>
                                <a title="Eliminar de la lista de deseos" @click="deleteWishlist(wishlist.id)" v-show="wishlist.product.price > 0" class="cart text-primary cursor-pointer">
                                    <i class="fa fa-trash" style="margin: 0 5px;"></i>
                                </a>
                              </td>
                            </tr>
                            <tr v-if="wishlists.length==0">
                              <td class="text-center" colspan="4">No hay productos en tu lista de deseos</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Extra Footer End Page --}}
        @include('icommerce::frontend.partials.extra-footer')

    </div>

@stop
@section('scripts')
    @parent
    <script>
        /* =========== VUE ========== */
        const vue_index_commerce = new Vue({
            el: '#content_index_commerce',
            data: {
                preloader: true,
                /*wishlist*/
                user: {!! $currentUser ? $currentUser->id : 0 !!},
                wishlists:[],
            },
            mounted: function () {
                this.getWishlist();
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
              /*agrega el producto al carro de compras*/
              addCart: function (item) {
                vue_carting.addItemCart(item.id,item.name,item.price);
                this.deleteWishlist(item.id);
              },
              /* products wishlist */
                 getWishlist: function () {
                   this.preloader=true;
                    if (this.user) {
                      let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: "{{url('/')}}"+"/api/icommerce/v3/wishlists",
                            params:{
                              filter:{
                                user:this.user
                              }
                            },
                            headers:{
                              'Authorization':token
                            }
                        }).then(response => {
                            this.wishlists = response.data.data;
                            this.preloader=false;
                        });
                    }//this.user
                },

                deleteWishlist(productId){
                  if (this.user) {
                    let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                      axios({
                          method: 'delete',
                          responseType: 'json',
                          url: "{{url('/')}}"+"/api/icommerce/v3/wishlists"+'/'+productId,
                          params:{},
                          headers:{
                            'Authorization':token
                          }
                      }).then(response => {
                        this.alerta("Producto eliminado de la listsa de deseos", "success");
                        this.getWishlist();
                      });
                  }//this.user
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
            }
        });
    </script>
@stop
