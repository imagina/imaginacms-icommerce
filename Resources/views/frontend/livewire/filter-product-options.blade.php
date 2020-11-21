	<div class="filter-product-options mb-4">

	<div class="content position-relative">
		@include('icommerce::frontend.partials.preloader')

		@if($productOptions && count($productOptions)>0)
			@foreach($productOptions as $key => $option)
				
				@includeFirst(
					['icommerce.index.product-option','icommerce::frontend.index.product-option'],
					['option'=> $option]
				)
			@endforeach
		@endif
	</div>

</div>
