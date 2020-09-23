

<div class="mb-4 bg-image" v-if="product_gallery && product_gallery.length>0">

  <div class="row">
    <div class="col-auto pr-md-0  order-1 order-sm-0">
      <div class="img-mini border mb-2" v-for="(img,index) in product_gallery" >

        <img data-target="#carouselGallery" v-bind:data-slide-to="index" v-bind:src="img.path">

      </div>
      <div class="img-mini border mb-2" >

        <img data-target="#carouselGallery" v-bind:data-slide-to="product_gallery.length" src="{{$product->mainImage->path}}">

      </div>
    </div>
    <div class="col-12 col-sm  order-0 order-sm-1">
      <div id="carouselGallery" class="carousel slide mb-3" data-ride="carousel">
        <div class="carousel-inner h-100 img-big position-relative">
          <div class="carousel-item h-100" v-for="(img,index) in product_gallery" v-bind:class="[ (index == 0) ? 'active' : '']">
            <a :href="img.path"  data-fancybox="gallery" :data-caption="product.title">
              <img  v-bind:src="img.path"  >
              <i class="fa fa-search-plus bt-search position-absolute" aria-hidden="true" style="bottom: 0; right: 3px;"></i>
            </a>
          </div>
          <div class="carousel-item h-100">
            <a href="{{$product->mainImage->path}}"  data-fancybox="gallery" data-caption="{{$product->title}}">
              <img  src="{{$product->mainImage->path}}"  >
              <i class="fa fa-search-plus bt-search position-absolute" aria-hidden="true" style="bottom: 0; right: 3px;"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="d-none d-md-block">
        @includeFirst(['icommerce.products.share','icommerce::frontend.products.share'])
      </div>

    </div>
  </div>

</div>

<div class="mb-4 bg-image" v-else >
  <div class="img-big position-relative mb-3">
    <a href="{{$product->mainImage->path}}" data-fancybox="{{$product->title}}" data-caption="{{$product->title}}">
      <img src="{{$product->mainImage->path}}" class="img-fluid w-100" alt="{{$product->title}}">

      <i class="fa fa-search-plus" aria-hidden="true" style="bottom: 18px; right: 18px; position: absolute; "></i>
    </a>
  </div>
  @includeFirst(['icommerce.products.share','icommerce::frontend.products.share'])
</div>

@section('scripts-owl')
  @parent
  <script>

    $(document).ready(function () {

      $('#owl-image-mini').owlCarousel({

        responsiveClass: true,
        nav: true,
        loop: true,
        dots: false,
        lazyContent: true,
        autoplay: true,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 2
          },
          768: {
            items: 2
          },
          992: {
            items: 2
          }
        }
      })

    });
  </script>
@endsection
