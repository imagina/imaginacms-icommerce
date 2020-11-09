<div class="top-content">

	<h4 class="text-primary text-uppercase font-weight-bold">{{$category->title ?? setting('icommerce::customIndexTitle',null,trans('icommerce::products.title.products'))}}</h4>
	<hr>

	<div class="row align-items-center mb-4">

		{{-- Total Products --}}
		<div class="col-lg-4">

			<div class="total-products">
				{{trans('icommerce::frontend.index.we found')}}:
				{{$totalProducts}}
				{{trans('icommerce::products.plural')}}
			</div>
			
		</div>

		{{-- Filter - Order By --}}
		<div class="col-lg-5">
			@includeFirst(['icommerce.filters.index.top-content.filter-orderby','icommerce::frontend.index.top-content.filter-orderby'])
		</div>

		{{-- Change Layout --}}
		<div class="col-lg-3">
			@includeFirst(['icommerce.index.top-content.change-layout','icommerce::frontend.index.top-content.change-layout']) 
		</div>
		
	</div>

</div>