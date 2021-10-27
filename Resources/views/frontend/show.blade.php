@extends('icommerce::structure.product-show')

@section('content')
  @parent
  <div class="page show show-product show-product-{{$product->id}}">
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

              @include('icommerce::frontend.partials.show.gallery')

              @include('icommerce::frontend.partials.show.share')

            </div>

            <div class="col-lg-6 mb-5">

              @include('icommerce::frontend.partials.show.information')

            </div>

            <div class="col-lg-12 mb-5">
              <div class="row">
                <div class="col-12 ">
                  <ul class="nav nav-tabs border-left border-right border-top" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#descripcion"
                         role="tab">{{ trans('icommerce::products.title.productDetails') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#comentarios"
                         role="tab">{{ trans('icommerce::products.title.comments') }}</a>
                    </li>

                    @if(setting('icommerce::showReviewsProduct') && is_module_enabled('Icomments'))
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#reviews"
                           role="tab">{{ trans('icommerce::products.title.reviews') }}</a>
                      </li>
                    @endif


                  </ul>
                </div>
              </div>
              <!-- Tab panes -->
              <div class="row">
                <div class="col-12">
                  <div class="tab-content border">

                    <div class="tab-pane active " id="descripcion" role="tabpanel">
                      <div class="p-3 p-md-5">
                        @include('icommerce::frontend.partials.show.tabs')
                      </div>
                    </div>

                    <div class="tab-pane" id="comentarios" role="tabpanel">
                      <div class="p-3 p-md-5">
                        <div class="fb-comments w-100" v-bind:data-href="product.url" data-numposts="5"
                             data-width="100%"></div>
                        <div id="fb-root"></div>
                      </div>
                    </div>

                    @if(setting('icommerce::showReviewsProduct') && is_module_enabled('Icomments'))
                      <div class="tab-pane" id="reviews" role="tabpanel">
                        <div class="p-3 p-md-5">

                          <x-icomments::comments :model="$product" :approved="true" />

                        </div>
                      </div>
                    @endif

                  </div>
                </div>
              </div>
            </div>



          </div>
        </div>
      </div>

      <div class="col-12">

        @include('icommerce::frontend.partials.show.related-products')

      </div>

    </div>

    {{-- Extra Footer End Page --}}
    @include('icommerce::frontend.partials.extra-footer')

  </div>
@stop

@section('scripts')
  @parent
  <script type="text/javascript" defer>(function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
@stop
