<div class="filter-product-options mb-4">

	<div class="content position-relative">
		@include('icommerce::frontend.partials.preloader')
		
		@if($options && count($options)>0)
			@foreach($options as $key => $option)
				
				@include('icommerce::frontend.livewire.index.filters.product-options.option',
					['option'=> $option]
				)
			@endforeach
		@endif
	</div>

</div>