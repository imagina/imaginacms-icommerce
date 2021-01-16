@extends('icommerce::structure.product-show')

@section('content')
  @parent
  <div class="page">
    <div id="content_preloader">
      <div id="preloader"></div>
    </div>

    <div id="content_show_commerce">

      {{-- Banner Top--}}
      @include("icommerce::frontend.partials.banner")

      <div id="content" class="product">
        <div class="container ">

          <div class="row">

            <div class="col-lg-6 mb-5">

              @include('icommerce::frontend.widgets.gallery')
  
              @include('icommerce::frontend.products.share')

            </div>

            <div class="col-lg-6 mb-5">
              
              @include('icommerce::frontend.widgets.information')
              
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
                        @includeFirst(['icommerce::frontend.products.tabs'])
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

            

          </div>
        </div>
      </div>

      <div class="col-12">

        @include('icommerce::frontend.products.related-products')

      </div>

    </div>

    {{-- Extra Footer End Page --}}
    @include('icommerce::frontend.partials.extra-footer')
    
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
