@extends('layouts.master')

{{-- Meta --}}
@includeFirst(['icommerce.index.meta','icommerce::frontend.index.meta'])


@section('content')
  
  <div id="content_index_commerce"
       class="page icommerce icommerce-index {{isset($category->id) ? 'icommerce-index-'.$category->id : ''}} py-5">
    
    {{-- Category Index Banner --}}
    @if(isset($category->id))
      @php($mediaFiles = $category->mediaFiles())
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
    
    
    <div class="container">
      <div class="row">
        
        {{-- Filters --}}
        <div class="col-lg-3">
          
          @includeFirst(['icommerce.index.filters',
          'icommerce::frontend.index.filters'],["categoryBreadcrumb" => $categoryBreadcrumb])
        </div>
        
        {{-- Top Content , Products, Pagination --}}
        <div class="col-lg-9">
          
          @livewire('icommerce::product-list',["category" => $category ?? null,"manufacturer" => $manufacturer ?? null])
          <hr>
        
        </div>
      
      </div>
    </div>
  
  </div>

@stop

{{-- VUEJS SCRIPTS--}}
@includeFirst(['icommerce.index.scripts','icommerce::frontend.index.scripts'])