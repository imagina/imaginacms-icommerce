<div class="filter-manufacturers mb-4">
	<div class="title">
		<a data-toggle="collapse" href="#collapseManufacturers" role="button" aria-expanded="false" aria-controls="collapseManufacturers">
	  		<div class="d-flex justify-content-between align-items-center">
	  			<h5 class="text-secondary">{{ trans('icommerce::manufacturers.plural') }}</h5>
	  			<i class="fa fa-arrow-right text-secondary" aria-hidden="true"></i>
	  		</div>
	  		<hr>
  		</a>
	</div>
	
	<div class="content position-relative">

		@include('icommerce::frontend.partials.preloader')

		<div class="collapse show" id="collapseManufacturers">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-manufacturers">

		  			@if($manufacturers && count($manufacturers)>0)
			  			@foreach($manufacturers as $manufacturer)
				  			<div class="form-check">
						  		<input class="form-check-input" type="checkbox" value="{{$manufacturer->id}}" name="manufacturers[]" id="manufacturer{{$manufacturer->id}}"  wire:model="selectedManufacturers.{{$manufacturer->id}}">
							  	<label class="form-check-label" for="manufacturer{{$manufacturer->id}}">
							    	{{$manufacturer->name}}
							  	</label>
							</div>
						@endforeach
					@endif

		  		</div>

		  	</div>
		  </div>
		</div>
	</div>
  	
  	
</div>

@section('scripts')
@parent

<script type="text/javascript">

console.warn("Componente: Filter Manufacturers - Start")

</script>

@stop