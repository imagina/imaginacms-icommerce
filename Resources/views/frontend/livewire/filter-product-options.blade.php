<div class="filter-product-options">

	<div class="title">
		<a data-toggle="collapse" href="#collapseProductOptions" role="button" aria-expanded="false" aria-controls="collapseProductOptions">
	  		<div class="d-flex justify-content-between align-items-center">
	  			
	  			@php($titleFilter = config("asgard.icommerce.config.filters.product-options.title"))
	  			<h5 class="text-secondary">{{ trans($titleFilter) }}</h5>
	  			<i class="fa fa-arrow-right text-secondary" aria-hidden="true"></i>
	  		</div>
	  		<hr>
  		</a>
	</div>

	<div class="content position-relative">

		@include('icommerce::frontend.partials.preloader')

		<div class="collapse" id="collapseProductOptions">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-product-options">

		  			Informacion
		  		</div>

		  	</div>
		  </div>
		</div>

	</div>

</div>