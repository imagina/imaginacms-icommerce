@extends('iprofile::frontend.layouts.master')


@section('title')
  {{trans("icommerce::wishlists.title.myWishlist")}}   | @parent
@stop


@section('profileTitle')
  {{trans("icommerce::wishlists.title.myWishlist")}}
@stop

@section('profileBreadcrumb')
  <x-isite::breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">Lista de Deseos</li>
  </x-isite::breadcrumb>
@endsection
@section('profileContent')
  
  
  <!-- preloader -->
  <div id="content_preloader" v-if="preloader">
    <div id="preloader"></div>
  </div>
  
  <div id="contentWishlist" class="row">
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
                <a :href="wishlist.product.url">
                  <img :src="wishlist.product.mediaFiles.mainimage.relativeSmallThumb" :alt="wishlist.product.name"
                       class="img-responsive img-fluid" style="width:100px;height:auto;">
                </a>
              
              </td>
              
              <td><a :href="wishlist.product.url"> @{{wishlist.product.name}} </a></td>
              <td>@{{wishlist.product.price | numberFormat}}</td>
              <td>
                <a title="Agregar al carro de compras"
                   :onClick="'window.livewire.emit(\'addToCart\','+wishlist.product.id+')'"
                   @click="deleteWishlist(wishlist.id)" v-show="wishlist.product.price > 0"
                   class="cart text-primary cursor-pointer">
                  <i class="fa fa-shopping-basket" style="margin: 0 5px;"></i>
                </a>
                <a title="Eliminar de la lista de deseos" @click="deleteWishlist(wishlist.id)"
                   v-show="wishlist.product.price > 0" class="cart text-primary cursor-pointer">
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




@stop
@section('profileExtraFooter')
  @include('icommerce::frontend.partials.extra-footer')
@endsection
@section('scripts')
  @parent
  <script>
    /* =========== VUE ========== */
    const vue_index_commerce = new Vue({
      el: '#contentWishlist',
      data: {
        preloader: true,
        /*wishlist*/
        user: {!! $currentUser ? $currentUser->id : 0 !!},
        wishlists: [],
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
          vue_carting.addItemCart(item.id, item.name, item.price);
          this.deleteWishlist(item.id);
        },
        /* products wishlist */
        getWishlist: function () {
          this.preloader = true;
          if (this.user) {
            let token = "Bearer " + "{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
            axios({
              method: 'get',
              responseType: 'json',
              url: "{{url('/')}}" + "/api/icommerce/v3/wishlists",
              params: {
                filter: {
                  user: this.user
                }
              },
              headers: {
                'Authorization': token
              }
            }).then(response => {
              this.wishlists = response.data.data;
              this.preloader = false;
            });
          }//this.user
        },
        
        deleteWishlist(productId) {
          if (this.user) {
            let token = "Bearer " + "{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
            axios({
              method: 'delete',
              responseType: 'json',
              url: "{{url('/')}}" + "/api/icommerce/v3/wishlists" + '/' + productId,
              params: {},
              headers: {
                'Authorization': token
              }
            }).then(response => {
              
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
