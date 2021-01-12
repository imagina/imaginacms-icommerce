<div class="banner-top">

@if(isset($carouselImages) && !empty($carouselImages))

  @include('icommerce::frontend.partials.carousel-index-image',[
        "gallery" => $carouselImages])

@endif
  
{{-- Breadcrumb --}}
@include('icommerce::frontend.partials.breadcrumb')

</div>