@extends('layouts.master')

{{-- Meta --}}
@include('icommerce::frontend.index.meta')


@section('content')
  
  <div id="content_index_commerce"
       class="page icommerce icommerce-index {{isset($category->id) ? 'icommerce-index-'.$category->id : ''}} py-5">
    
    {{-- Banner Top--}}
    @include("icommerce::frontend.partials.banner")
    
    <div class="container">
      <div class="row">
        
        {{-- Sidebar --}}
        <div class="col-lg-3">

          {{-- Breadcrumb Optional --}}
          @if(setting('icommerce::showBreadcrumbSidebar'))
            @include('icommerce::frontend.partials.breadcrumb')
          @endif

          {{-- Manufacturer Card Optional --}}
          {{--
          @include('icommerce::frontend.partials.manufacturer-card')
          --}}
          
          {{-- Filters --}}
          @include('icommerce::frontend.index.filters',[
            "categoryBreadcrumb" => $categoryBreadcrumb])

          {{-- Extra Widgets --}}
          @if(config("asgard.icommerce.config.widgets"))
            <div class="widgets">
            @foreach(config("asgard.icommerce.config.widgets") as $widget)
              @if($widget['status'])
            
                <x-dynamic-component 
                  :component="$widget['component']" 
                  :id="$widget['id']" 
                  :isExpanded="$widget['isExpanded']" 
                  :title="$widget['title']"
                  :props="$widget['props']"
                />
               
              @endif
            @endforeach
            </div>
          @endif
         
        </div>
        
        {{-- Top Content , Products, Pagination --}}
        <div class="col-lg-9">
         
          @if(isset($gallery) && !empty($gallery))
            @include('icommerce::frontend.partials.carousel-index-image')
          @endif

          <livewire:icommerce::product-list
            :category="$category ?? null" 
            :manufacturer="$manufacturer ?? null" />

          <hr>
        
        </div>
      
      </div>
    </div>
  

    {{-- Extra Footer End Page --}}
    @include('icommerce::frontend.partials.extra-footer')

  </div>

@stop

{{-- VUEJS SCRIPTS--}}
@includeFirst(['icommerce.index.scripts','icommerce::frontend.index.scripts'])