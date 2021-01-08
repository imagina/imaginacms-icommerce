<div class="banner-top">
@if(isset($category->id))
  @php 
    $mediaFiles = $category->mediaFiles();
  @endphp

  @if(isset($mediaFiles->bannerindeximage->path) && !strpos($mediaFiles->bannerindeximage->path,"default.jpg"))
    @include('icommerce::frontend.partials.category-index-banner')
  @else
      {{-- Breadcrumb --}}
    @include('icommerce::frontend.partials.breadcrumb')
  @endif

@else
  {{-- Breadcrumb --}}
  @include('icommerce::frontend.partials.breadcrumb')

@endif
</div>