@extends('layouts.master')

{{-- Meta --}}
@include('icommerce::frontend.index.meta')


@section('content')

<div id="content_index_commerce" class="page icommerce icommerce-index {{isset($category->id) ? 'icommerce-index-'.$category->id : ''}} py-5">
	
	{{-- Breadcrumb --}}
	@include('icommerce::frontend.partials.breadcrumb')
	
	<div class="container">
		<div class="row">

			{{-- Filters --}}
			<div class="col-lg-3">
			
				@include('icommerce::frontend.index.filters',[
					"categoryBreadcrumb" => $categoryBreadcrumb
					])
			</div>

			{{-- Top Content , Products, Pagination --}}
			<div class="col-lg-9">
				
				@livewire('icommerce::products-list',["category" => $category ?? null,"manufacturer" => $manufacturer ?? null])
				<hr>

			</div>
			
		</div>
	</div>

</div>

@stop

{{-- VUEJS SCRIPTS--}}
@include('icommerce::frontend.index.scripts')