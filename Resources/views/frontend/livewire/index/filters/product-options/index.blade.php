<div class="filter-product-options mb-4">

	<div class="content position-relative">
		@include('icommerce::frontend.partials.preloader')
		
		@if($this->options && count($this->options)>0)
			@foreach($this->options as $key => $option)
				
				@include('icommerce::frontend.livewire.index.filters.product-options.option',
					['option'=> $option]
				)
			@endforeach
		@endif
	</div>

</div>