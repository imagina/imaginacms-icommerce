<div class="top-content mb-2">

	@include('icommerce::frontend.livewire.index.top-content.custom-titles')

	<div class="options-product-list d-none d-lg-block d-xl-block">

		<div class="row align-items-center">

			{{-- Total Products --}}
			<div class="col-lg-4">
				@include('icommerce::frontend.livewire.index.top-content.total-products')
			</div>

			{{-- Filter - Order By --}}
			<div class="col-lg-5">
				@include('icommerce::frontend.livewire.index.top-content.filter-orderby')
			</div>

			{{-- Change Layout --}}
			<div class="col-lg-3">
				@include('icommerce::frontend.livewire.index.top-content.change-layout') 
			</div>
			
		</div>

	</div>

	@include('icommerce::frontend.livewire.index.top-content.mobile.index')

	
</div>