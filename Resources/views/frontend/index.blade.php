@extends('layouts.livewire')

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
				
				@includeFirst(['icommerce.index.top-content',
				'icommerce::frontend.index.top-content'])
				
				<hr>
				<h2>Prueba de Livewire</h2>
				<hr>
				{{--
				@livewire('counter')
				--}}
				{{--
				@livewire(Modules\Icommerce\Http\Livewire\Counter::class)
				--}}
				
				@livewire('icommerce::counter')

				@livewire('icommerce::test')
				
				<hr>

			</div>
			
		</div>
	</div>

</div>

@stop

{{-- VUEJS SCRIPTS--}}
@includeFirst(['icommerce.index.scripts','icommerce::frontend.index.scripts'])