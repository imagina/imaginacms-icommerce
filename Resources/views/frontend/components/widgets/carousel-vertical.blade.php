<div class="carousel-vertical">

	<x-icommerce-widget-base :id="$id" :isExpanded="$isExpanded">
        <x-slot name="title">
               {{$title}}
        </x-slot>
        <x-slot name="content">
                  <x-isite-owl-carousel 
                  :id="$id" 
                  repository="Modules\Icommerce\Repositories\ProductRepository"
                  :params="$props['params']" 
                  :responsive="$props['responsive']"/>
        </x-slot>
   	</x-icommerce-widget-base>
   
</div>