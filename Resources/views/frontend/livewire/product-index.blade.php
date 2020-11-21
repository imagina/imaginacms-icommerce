<section class="iblock general-block12 py-5" data-blocksrc="general.block12">
  <div class="container">
    <div class="row">
      <div class="col-12">
      
        <div class="title-arrow text-center mb-5">
          <h2 class="px-5 bg-white"><strong>NUEVOS</strong> PRODUCTOS</h2>
        </div>
        
        <div id="productIndex" class="owl-carousel owl-theme">
            @foreach($products as $product)
            @include('icommerce::frontend.product.layout')
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>



@section('scripts-owl')
  <script>
    $(document).ready(function(){
      var owl = $('#productIndex');
      
      owl.owlCarousel({
        loop: true,
        lazyLoad:true,
        margin: 10,
        dots: false,
        responsiveClass: true,
        autoplay: true,
        autoplayHoverPause: true,
        nav:true,
        responsive: {
          0: {
            items: 1
          },
          640: {
            items: 2
          },
          992: {
            items: 4
          }
        }
      });
      
    });
  </script>
  
  @parent

@stop
