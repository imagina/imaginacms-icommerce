<div class="top-content">

	<h4 class="text-primary text-uppercase font-weight-bold">{{$category->title ?? setting('icommerce::customIndexTitle',null,trans('icommerce::products.title.products'))}}</h4>
	<hr>

	<div class="row align-items-center mb-4">

		{{-- Total Products --}}
		<div class="col-lg-4">

			<div class="total-products">
				{{trans('icommerce::frontend.index.we found')}}:
				XXXXX
				{{trans('icommerce::products.plural')}}
			</div>
			
		</div>

		{{-- Filter - Order By --}}
		<div class="col-lg-5">
			@livewire('icommerce::filter-orderby')
			{{--
			@includeFirst(['icommerce.filters.order-by','icommerce::frontend.livewire.filter-orderby'])
			--}}
		</div>

		{{-- Change Layout --}}
		<div class="col-lg-3">
			@includeFirst(['icommerce.index.change-layout','icommerce::frontend.index.change-layout']) 
		</div>
		
	</div>

</div>