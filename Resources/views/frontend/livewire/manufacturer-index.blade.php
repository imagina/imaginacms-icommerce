  <div id="manufacturerIndex" class="owl-carousel owl-theme">
    @foreach($manufacturers as $manufacturer)
      
      <slide wire:key="manufacturerIndex-{{$manufacturer->id}}">
        <a href="{{$manufacturer->url}}" style="color : inherit">
          <div class="bg-image cover-img-4-3">
            <img alt="{{$manufacturer->name}}" src="{{$manufacturer->mediaFiles()->mainimage->path}}" class="lazyload">
          </div>
          
        </a>
      </slide>
    @endforeach
  </div>



@section('scripts-owl')
  <script>
    $(document).ready(function () {
      var owl = $('#manufacturerIndex');
      
      owl.owlCarousel({
        loop: true,
        lazyLoad:true,
        margin: 10,
        speed: 500,
        dots: false,
        responsiveClass: true,
        autoplay: true,
        autoplayHoverPause: true,
        nav: false,
        responsive: {
          0: {
            items: 3
          },
          480: {
            items: 3
          },
          768: {
            items: 4
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
