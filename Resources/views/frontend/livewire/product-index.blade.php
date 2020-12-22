<section id="{{$name}}" class="iblock general-block12 py-5" data-blocksrc="general.block12">
  <div class="container">
    <div class="row">
      <div class="col-12">
      
        <div class="text-title title-arrow text-center mb-4">
          <h2 class="title px-5">{!! $title !!}</h2>
          <h6 class="subtitle">
            {!! $subTitle !!}
          </h6>
        </div>
        
        <div id="{{$name}}Carousel" class="owl-carousel owl-theme">
            @foreach($products as $product)
            <x-icommerce::product-list-item :product="$product" />
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>



@section('scripts-owl')
  <script>
    $(document).ready(function(){
      var owl = $('#{{$name}}Carousel');
      
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
