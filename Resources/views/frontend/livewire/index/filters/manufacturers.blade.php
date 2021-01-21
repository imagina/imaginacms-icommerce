<div class="filter-manufacturers mb-4">
@if($manufacturers && count($manufacturers)>0)
	<div class="title">
		<a class="item" data-toggle="collapse" href="#collapseManufacturers" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapseManufacturers" class="{{$isExpanded ? '' : 'collapsed'}}">
	  		
	  		
	  		@php($titleFilter = config("asgard.icommerce.config.filters.manufacturers.title"))
	  		<h5 class="p-3 border-top border-bottom">
	  			{{ trans($titleFilter) }}
	  			<i class="fa fa angle float-right" aria-hidden="true"></i>
	  		</h5>

  		</a>
	</div>
	
	<div class="content position-relative">

		@include('icommerce::frontend.partials.preloader')

		<div class="collapse {{$isExpanded ? 'show' : ''}} m-3" id="collapseManufacturers">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-manufacturers">

			  			@foreach($manufacturers as $manufacturer)
				  			<div class="form-check">
						  		<input class="form-check-input" type="checkbox" value="{{$manufacturer->id}}" name="manufacturers{{$manufacturer->id}}" id="manufacturer{{$manufacturer->id}}"  wire:model="selectedManufacturers">
							  	<label class="form-check-label" for="manufacturer{{$manufacturer->id}}">
							    	{{$manufacturer->name}}
							  	</label>
							</div>
						@endforeach


		  		</div>

		  	</div>
		  </div>
		</div>
	</div>
@endif
  	
</div>