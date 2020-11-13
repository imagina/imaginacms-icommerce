<div class="filters">
	
	@livewire('icommerce::filter-categories',[
		"categoryBreadcrumb" => $categoryBreadcrumb,
		"manufacturer" => $manufacturer ?? null
		])

	@livewire('icommerce::filter-range-prices')
	
	@if(!isset($manufacturer->id))
<<<<<<< Updated upstream
	@livewire('icommerce::filter-manufacturers')
=======
		@livewire('icommerce::filter-manufacturers')
>>>>>>> Stashed changes
	@endif
	
</div>