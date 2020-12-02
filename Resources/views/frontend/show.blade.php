@extends('icommerce::structure.product-show')

@section('content')
  @parent
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
{{--
    @include('partials.subcription')

    @include('partials.brands')
    --}}
  </div>
@stop

@section('scripts')
  @parent
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
