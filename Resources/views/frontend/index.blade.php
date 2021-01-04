@extends('layouts.master')

{{-- Meta --}}
@includeFirst(['icommerce.index.meta','icommerce::frontend.index.meta'])


@section('content')
  
  <div id="content_index_commerce"
       class="page icommerce icommerce-index {{isset($category->id) ? 'icommerce-index-'.$category->id : ''}} py-5">
    
    {{-- Banner Top--}}
    @include("icommerce::frontend.partials.banner")
    
    <div class="container">
      <div class="row">
        
        {{-- Filters, Widgets --}}
        <div class="col-lg-3">
          
          @includeFirst(['icommerce.index.filters',
          'icommerce::frontend.index.filters'],["categoryBreadcrumb" => $categoryBreadcrumb])

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