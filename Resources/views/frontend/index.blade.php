@extends('layouts.livewire')

{{-- Meta --}}
@includeFirst(['icommerce.index.meta','icommerce::frontend.index.meta'])


@section('content')

<div id="content_index_commerce" class="page icommerce icommerce-index py-5">

	<div class="container">
		<div class="row">

			{{-- Filters --}}
			<div class="col-lg-3">
				@includeFirst(['icommerce.index.filters',
				'icommerce::frontend.index.filters'])
			</div>

			{{-- Top Content , Products, Pagination --}}
			<div class="col-lg-9">
				
				@includeFirst(['icommerce.index.top-content',
				'icommerce::frontend.index.top-content'])
				
				
				@livewire('icommerce::products-list')
				
				
				<hr>

			</div>
			
		</div>
	</div>

</div>

@stop

{{-- VUEJS SCRIPTS--}}
@includeFirst(['icommerce.index.scripts','icommerce::frontend.index.scripts'])