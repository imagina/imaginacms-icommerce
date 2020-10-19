@extends('layouts.master')

{{-- Meta --}}
@includeFirst(['icommerce.index.meta','icommerce::frontend.index.meta'])


@section('content')

<div id="content_index_commerce" class="page icommerce icommerce-index py-5">

	<div class="container">
		<div class="row">

			{{-- Filters --}}
			<div class="col-lg-3">
				@includeFirst(['icommerce.filters.index',
				'icommerce::frontend.filters.index'])
			</div>

			{{-- Top Content , Products, Pagination --}}
			<div class="col-lg-9">
				
				@includeFirst(['icommerce.filters.index','icommerce::frontend.index.top-content'])

			</div>
			
		</div>
	</div>

</div>


@stop