@extends('icommerce::structure.product-show')

@section('content')
  @parent
  <div class="page">
    <div id="content_preloader">
      <div id="preloader"></div>
    </div>

    <div id="content_show_commerce">

      <!-- MIGA DE PAN  -->
      @component('icommerce::frontend.widgets.breadcrumb')
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
            </div>

            <div class="col-lg-12 mb-5">
              <div class="row">
                <div class="col-12 ">
                  <ul class="nav nav-tabs border-left border-right border-top" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#descripcion"
                         role="tab">{{trans('icommerce::common.details')}}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#comentarios"
                         role="tab">{{trans('icommerce::common.comments')}}</a>
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
