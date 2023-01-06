@extends('layouts.master')

{{-- Meta --}}
@include('icommerce::frontend.partials.index.meta')


@section('content')

  <div id="content_index_commerce"
       class="page icommerce icommerce-index {{isset($category->id) ? 'icommerce-index-category icommerce-index-category-'.$category->id : ''}} py-5 {{isset($manufacturer->id) ? 'icommerce-index-manufacturer icommerce-index-manufacturer-'.$manufacturer->id : ''}}">
	
    {{-- Banner Top--}}
    @include("icommerce::frontend.partials.banner")
	
	<div class="container">
		<div class="row">

        {{-- Sidebar --}}
			<div class="col-lg-3 sidebar">
			
          {{-- Breadcrumb Optional --}}
          @if(setting('icommerce::showBreadcrumbSidebar'))
            @include('icommerce::frontend.partials.breadcrumb')
          @endif


          {{-- Custom Includes --}}
          @if(config("asgard.icommerce.config.customIncludesBeforeFilters"))
            @foreach(config("asgard.icommerce.config.customIncludesBeforeFilters") as $custom)

                @if(in_array("store",$custom['show']))
                  @include($custom['view'])
                @endif

                @if(in_array("manufacturer",$custom['show']) && isset($manufacturer->id))
                  @include($custom['view'])
                @endif

                @if(in_array("category",$custom['show']) && isset($category->id))
                  @include($custom['view'])
                @endif

            @endforeach
          @endif

          {{-- FILTERS --}}
          <livewire:isite::filters :filters="config('asgard.icommerce.config.filters')"/>

          {{-- Custom Includes --}}
          @if(config("asgard.icommerce.config.customIncludesAfterFilters"))
            @foreach(config("asgard.icommerce.config.customIncludesAfterFilters") as $custom)

                @if(in_array("store",$custom['show']))
                  @include($custom['view'])
                @endif

                @if(in_array("manufacturer",$custom['show']) && isset($manufacturer->id))
                  @include($custom['view'])
                @endif

                @if(in_array("category",$custom['show']) && isset($category->id))
                  @include($custom['view'])
                @endif

            @endforeach
          @endif

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
         
          @if(isset(tenant()->id) && config("asgard.icommerce.config.useTenantHeaderInTheIndex"))
            @include("icommerce::frontend.partials.index.organization-header")
          @endif
          
          @if(isset($gallery) && !empty($gallery))
            @include('icommerce::frontend.partials.carousel-index-image')
          @endif
          
          @if(setting("icommerce::showCategoryChildrenIndexHeader"))
            @include('icommerce::frontend.partials.children-categories-index-section',["category" => $category ?? null])
          @endif
          
          <livewire:isite::items-list 
            moduleName="Icommerce"
            itemComponentName="icommerce::product-list-item"
            itemComponentNamespace="Modules\Icommerce\View\Components\ProductListItem"
            entityName="Product"
            :title="$title"
            :description="isset($category->options->descriptionIndex) && !empty($category->options->descriptionIndex) ? $category->options->descriptionIndex : null "
            :params="[
            'filter' => ['category' => $category->id ?? null, 'manufacturers' => isset($manufacturer->id) ? [$manufacturer->id] : [],'withDiscount' => isset($withDiscount) ? $withDiscount : false],
            'include' => ['discounts','translations','category','categories','manufacturer','productOptions'], 
            'take' => setting('icommerce::product-per-page',null,12)]"
            :configOrderBy="config('asgard.icommerce.config.orderBy')"
            :pagination="config('asgard.icommerce.config.pagination')"
            :configLayoutIndex="config('asgard.icommerce.config.layoutIndex')"/>
          
          <hr>
        
        </div>
      
      </div>
    </div>
  

    {{-- Extra Footer End Page --}}
    @include('icommerce::frontend.partials.extra-footer')

  </div>

@stop