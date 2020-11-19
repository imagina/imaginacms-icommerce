<div class="filters">
	
	@livewire('icommerce::filter-categories',[
		"categoryBreadcrumb" => $categoryBreadcrumb,
		"manufacturer" => $manufacturer ?? null
		])

	@livewire('icommerce::filter-range-prices')
	
	@if(!isset($manufacturer->id))
		@livewire('icommerce::filter-manufacturers')
	@endif

	@livewire('icommerce::filter-product-options')
	
</div>