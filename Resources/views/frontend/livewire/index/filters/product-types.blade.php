<div class="filter-product-types mb-4">
@if($show)

	<div class="title">
		<a class="item" data-toggle="collapse" href="#collapseProductTypePrice" role="button" aria-expanded="{{$isExpanded ? 'true' : 'false'}}" aria-controls="collapseProductTypePrice" class="{{$isExpanded ? '' : 'collapsed'}}">
	  		
	  			
	  		@php($titleFilter = config("asgard.icommerce.config.filters.product-types.title"))
	  		<h5 class="p-3 border-top border-bottom">
	  			{{ trans($titleFilter) }}
	  			<i class="fa fa angle float-right" aria-hidden="true"></i>
	  		</h5>

  		</a>
	</div>

	<div class="content position-relative">

		@include('icommerce::frontend.partials.preloader')

		<div class="collapse {{$isExpanded ? 'show' : ''}}" id="collapseProductTypePrice">
		  <div class="row">
		  	<div class="col-12">
		  		
		  		<div class="list-ptpo">

		  			@foreach($productTypes as $key => $option)
		  				@if($option['status'])
		  				<div class="form-check">
		  					<input class="form-check-input" type="radio" 
		  					value="{{$option['value']}}" 
		  					name="ptpo{{$key}}" 
		  					id="ptpo{{$key}}"
		  					wire:model="selectedType">
							<label class="form-check-label" 
							for="ptpo{{$key}}">
							    	{{trans($option['title'])}}
							</label>
		  				</div>
		  				@endif
		  			@endforeach

		  		</div>

		  	</div>
		  </div>
		</div>

	</div>

 @endif
</div>