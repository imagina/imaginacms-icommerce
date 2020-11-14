<section class="iblock general-block13 pb-5" data-blocksrc="general.block13">
  <div id="categoryIndex" class="owl-carousel owl-theme">
    @foreach($categories as $category)
      <slide wire:key="categoryIndex-{{$category->id}}">
        <a href="{{$category->url}}" style="color : inherit">
          <div class="card card-categories position-relative text-white border-0">
            <div class="cover-img-16">
              <img alt="{{$category->title}}" src="{{$category->mediaFiles()->mainimage->mediumThumb}}" >
            </div>
            <div class="card-img-overlay px-0">
              <div class="pl-5 mb-4">
                <img src="/assets/media/iconos/ic-{{$category->slug}}.png" class="img-fluid">
                <h5 class="card-title text-uppercase">{{$category->title}}</h5>
              </div>
              <div class="btn link btn-warning px-4 text-dark  py-2 ">
                COMPRA AQUI
              </div>
            </div>
          </div>
        </a>
      </slide>
    @endforeach
  </div>
</section>



@section('scripts-owl')
  <script>
    $(document).ready(function () {
      var owl = $('#categoryIndex');
      
      owl.owlCarousel({
        loop: true,
        lazyLoad:true,
        margin: 10,
        dots: false,
        responsiveClass: true,
        autoplay: true,
        autoplayHoverPause: true,
        nav: true,
        responsive: {
          0: {
            items: 1
          },
          640: {
            items: 2
          },
          992: {
            items: 3
          }
        }
      });
      
    });
  </script>
  
  @parent

@stop
