@if(count(productgallery($product->id)) > 0)

    <div class="gallery">
        <div class="owl-carousel owl-theme">
            @foreach(productgallery($product->id) as $image)

                <div class="item">

                    <a href="{{asset($image)}}" data-fancybox="gallery">
                        <img src="{{asset($image)}}" alt="Gallery Image">
                    </a>

                </div>

            @endforeach
        </div>
    </div>
@endif

@section('scripts')
    <script>
        $(document).ready(function(){
            var owl = $('.gallery .owl-carousel');

            owl.owlCarousel({
                margin: 1,
                nav: true,
                loop: false,
                lazyContent: true,
                autoplay: true,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
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