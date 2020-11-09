<div class="filter-manufacturers mb-4">
  <h4 class="text-secondary">{{ trans('icommerce::manufacturers.plural') }}</h4>
  <hr>

  <div class="row">
  	<div class="col-12">
  		
  		<div class="list-manufacturers">

  			<div class="form-check">
		  		<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
			  	<label class="form-check-label" for="defaultCheck1">
			    	Marca 1
			  	</label>
			</div>

			<div class="form-check">
		  		<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
		  		<label class="form-check-label" for="defaultCheck1">
		    		Marca 2
		  		</label>

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